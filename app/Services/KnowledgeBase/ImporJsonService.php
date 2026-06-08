<?php

namespace App\Services\KnowledgeBase;

use App\Models\HurufTugas;
use App\Models\ContohGramatika;
use App\Models\KaidahGramatika;
use App\Models\BabJurumiyah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ImporJsonService
{
    /**
     * Import data dari file JSON Jurumiyah.
     *
     * @param string $jsonPath
     * @return void
     * @throws InvalidArgumentException
     */
    public function import(string $jsonPath): void
    {
        // 1. Validation Layer (Validasi keberadaan dan format file)
        $this->validateFile($jsonPath);

        $jsonContent = file_get_contents($jsonPath);
        $data = json_decode($jsonContent, true);

        $this->validateJsonStructure($data);

        // Bersihkan data lama untuk menjamin idempotensi (tidak ada duplikat)
        $this->clearDatabase();

        // 2. Database Transaction (Menjamin keamanan & integritas data)
        DB::transaction(function () use ($data) {
            // 3. Mapping Layer (Memetakan data JSON ke tabel-tabel terkait)
            foreach ($data as $index => $chapterItem) {
                $title = Str::lower($chapterItem['chapter']);
                $step = 3; // Default: Isim Dasar / Isim
                
                if (Str::contains($title, 'kalam')) {
                    $step = 1;
                } elseif (Str::contains($title, ['i\'rab', 'pengi\'raban', 'tanda'])) {
                    $step = 2;
                } elseif (Str::contains($title, 'fi\'il')) {
                    $step = 4;
                } elseif (Str::contains($title, 'huruf')) {
                    $step = 5;
                } elseif (Str::contains($title, ['dirafa\'', 'fa\'il', 'mubtada', 'khabar', 'naibul', 'nawasih'])) {
                    $step = 6;
                } elseif (Str::contains($title, ['dibaca', 'maf\'ul', 'mashdar', 'dzharaf', 'haal', 'tamyiz', 'istitsna', 'laa', 'munada'])) {
                    $step = 7;
                } elseif (Str::contains($title, ['dikhafadh', 'majrurat'])) {
                    $step = 8;
                } elseif (Str::contains($title, ['na\'at', 'athaf', 'taukid', 'badal'])) {
                    $step = 9;
                }

                $chapter = BabJurumiyah::create([
                    'judul' => $chapterItem['chapter'],
                    'definisi' => $chapterItem['definition'],
                    'matan_arab' => $chapterItem['matan_arab'] ?? null,
                    'nomor_urut' => $index + 1,
                    'langkah_belajar' => $step,
                ]);

                // Map Rules (Kaidah)
                foreach ($chapterItem['rules'] as $ruleIndex => $ruleText) {
                    $ruleCode = 'RULE_' . strtoupper(Str::slug($chapter->judul, '_')) . '_' . ($ruleIndex + 1);

                    KaidahGramatika::create([
                        'bab_id' => $chapter->id,
                        'kode_kaidah' => $ruleCode,
                        'teks_kaidah' => $ruleText,
                    ]);

                    // Ekstraksi partikel Arab secara dinamis
                    $this->extractParticlesFromRule($chapter->id, $ruleText);
                }

                // Map Examples (Contoh Kalimat)
                foreach ($chapterItem['examples'] as $exampleItem) {
                    ContohGramatika::create([
                        'bab_id' => $chapter->id,
                        'teks_arab' => $exampleItem['arabic'],
                        'terjemahan' => $exampleItem['translation'],
                    ]);
                }
            }
        });
    }

    /**
     * Memvalidasi keberadaan file fisik.
     */
    protected function validateFile(string $path): void
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException("File JSON tidak ditemukan pada path: {$path}");
        }
    }

    /**
     * Memvalidasi struktur skema JSON.
     */
    protected function validateJsonStructure(?array $data): void
    {
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("Struktur JSON tidak valid: " . json_last_error_msg());
        }

        if (!is_array($data)) {
            throw new InvalidArgumentException("Root JSON harus berupa array objek.");
        }

        foreach ($data as $index => $chapterItem) {
            $requiredKeys = ['chapter', 'definition', 'rules', 'examples'];
            foreach ($requiredKeys as $key) {
                if (!isset($chapterItem[$key])) {
                    throw new InvalidArgumentException("Kunci wajib '{$key}' tidak ditemukan pada elemen indeks {$index}.");
                }
            }

            if (!is_array($chapterItem['rules'])) {
                throw new InvalidArgumentException("Kunci 'rules' pada bab '{$chapterItem['chapter']}' harus bertipe array.");
            }

            if (!is_array($chapterItem['examples'])) {
                throw new InvalidArgumentException("Kunci 'examples' pada bab '{$chapterItem['chapter']}' harus bertipe array.");
            }
        }
    }

    /**
     * Mengosongkan tabel terkait sebelum proses import ulang.
     */
    protected function clearDatabase(): void
    {
        Schema::disableForeignKeyConstraints();

        HurufTugas::truncate();
        ContohGramatika::truncate();
        KaidahGramatika::truncate();
        BabJurumiyah::truncate();

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Parsing dan mengekstrak partikel tugas bahasa Arab secara otomatis.
     */
    protected function extractParticlesFromRule(int $chapterId, string $ruleText): void
    {
        $keywords = [
            'jar' => ['huruf jar', 'huruf khafadh'],
            'amp' => ['amil nashab', 'amil penashab'],
            'jazm' => ['amil jazm', 'amil penjazem', 'amil jazam'],
            'athaf' => ['huruf \'athaf', 'huruf athaf'],
        ];

        $matchedType = null;
        $lowerText = Str::lower($ruleText);

        foreach ($keywords as $type => $phrases) {
            foreach ($phrases as $phrase) {
                if (Str::contains($lowerText, $phrase)) {
                    $matchedType = $type;
                    break 2;
                }
            }
        }

        if ($matchedType) {
            $targetSegment = $ruleText;

            // Cari tulisan di dalam tanda kurung untuk meminimalisasi noise parsing
            if (preg_match('/\(([^)]+)\)/u', $ruleText, $matches)) {
                $targetSegment = $matches[1];
            } elseif (Str::contains($ruleText, ':')) {
                $targetSegment = Str::after($ruleText, ':');
            }

            // Dapatkan seluruh karakter/kata berbahasa Arab
            preg_match_all('/\p{Arabic}+/u', $targetSegment, $words);

            if (!empty($words[0])) {
                foreach ($words[0] as $word) {
                    $word = trim($word);
                    // Hapus koma arab (،), titik koma arab (؛) dan tanda tanya arab (؟)
                    $word = preg_replace('/[،؛؟]/u', '', $word);
                    $word = trim($word);
                    if (!empty($word)) {
                        HurufTugas::firstOrCreate([
                            'bab_id' => $chapterId,
                            'kata' => $word,
                            'jenis_partikel' => $matchedType,
                        ]);
                    }
                }
            }
        }
    }
}
