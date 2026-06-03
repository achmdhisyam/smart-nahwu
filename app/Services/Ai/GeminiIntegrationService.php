<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiIntegrationService
{
    protected $promptBuilder;
    protected $formatter;
    protected $cache;

    public function __construct(
        PromptBuilderService $promptBuilder,
        ResultFormatterService $formatter,
        AnalysisCacheService $cache
    ) {
        $this->promptBuilder = $promptBuilder;
        $this->formatter = $formatter;
        $this->cache = $cache;
    }

    /**
     * Menganalisis kalimat Arab secara hibrida menggunakan NLP lokal + Gemini API.
     *
     * @param string $sentence Teks Arab asli dari input
     * @param array $nlpResult Hasil tokenisasi dan deteksi lokal dari Rule Engine
     * @param array $relatedRules Kaidah Matan Al-Ajurrumiyyah yang relevan
     * @param int|null $userId ID user jika login (opsional)
     * @return array
     */
     public function analyze(string $sentence, array $nlpResult, array $relatedRules, ?int $userId = null): array
     {
         // 1. Cek Caching Layer untuk menghemat biaya API & mempercepat respon
         $hash = $this->cache->makeHash($sentence);
         $cachedResult = $this->cache->get($hash);
 
         if ($cachedResult) {
             return $cachedResult;
         }
 
         // 2. Cek apakah API Key Gemini dikonfigurasi. Jika tidak ada, gunakan Fallback Rule-Based NLP Lokal.
         $apiKey = env('GEMINI_API_KEY') ?? config('services.gemini.key');
 
         if (empty($apiKey)) {
             $localResult = $this->fallbackToLocalRuleEngine($sentence, $nlpResult, $relatedRules);
             
             // Simpan ke cache agar pemrosesan offline tetap instan
             $this->cache->set($sentence, $hash, $localResult, $userId);
             
             return $localResult;
         }
 
         // 3. Buat instruksi prompt terstruktur untuk Gemini
         $prompt = $this->promptBuilder->buildPrompt($sentence, $nlpResult, $relatedRules);

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key={$apiKey}";

        // Gunakan retry policy (3x percobaan, jeda 100ms) untuk mengantisipasi jaringan unstable
        $response = Http::retry(3, 100)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($apiUrl, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json'
                ]
            ]);

        if ($response->failed()) {
            Log::error("Gemini API Error: " . $response->body());
            // Fallback otomatis ke rule-based lokal jika request API gagal di server
            return $this->fallbackToLocalRuleEngine($sentence, $nlpResult, $relatedRules);
        }

        $responseBody = $response->json();
        $rawText = $responseBody['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (empty($rawText)) {
            return $this->fallbackToLocalRuleEngine($sentence, $nlpResult, $relatedRules);
        }

        try {
            // 4. Bersihkan dan validasi skema hasil
            $formattedResult = $this->formatter->format($rawText);

            // Pastikan field jurumiyah_reference_code terisi secara aman dan ganti kode RULE_ dengan isi teks kaidah
            if (isset($formattedResult['word_by_word_analysis']) && is_array($formattedResult['word_by_word_analysis'])) {
                $allRules = \App\Models\GrammarRule::all();
                foreach ($formattedResult['word_by_word_analysis'] as $index => &$item) {
                    if (!isset($item['jurumiyah_reference_code'])) {
                        $item['jurumiyah_reference_code'] = $nlpResult['tokens'][$index]['rule_reference']['chapter_title'] ?? null;
                    }

                    // Penggantian aman kode RULE_ jika AI tetap mengembalikannya
                    if (isset($item['explanation'])) {
                        foreach ($allRules as $rule) {
                            if (stripos($item['explanation'], $rule->rule_code) !== false) {
                                $item['explanation'] = str_ireplace($rule->rule_code, '"' . $rule->rule_text . '"', $item['explanation']);
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning("Gagal memformat output Gemini, beralih ke Lokal. Error: " . $e->getMessage());
            return $this->fallbackToLocalRuleEngine($sentence, $nlpResult, $relatedRules);
        }

        // 5. Simpan ke cache database untuk penggunaan selanjutnya
        $this->cache->set($sentence, $hash, $formattedResult, $userId);

        return $formattedResult;
    }

    /**
     * Fallback ke penganalisis pola lokal jika API Key belum diset atau koneksi gagal.
     */
    protected function fallbackToLocalRuleEngine(string $sentence, array $nlpResult, array $relatedRules): array
    {
        $wordAnalysis = [];
        $tokens = $nlpResult['tokens'] ?? [];
        $sentenceType = $nlpResult['sentence_type'] ?? 'Jumlah Ismiyah';

        // Hitung index Isim non-particle untuk menentukan peran sintaksis (Fa'il, Maf'ul, Mubtada, Khabar)
        $isimCount = 0;

        foreach ($tokens as $index => $token) {
            $text = $token['text'];
            $isParticle = $token['is_particle'] ?? false;
            $particleType = $token['particle_type'] ?? null;
            $ref = $token['rule_reference'] ?? null;

            // Nilai Default Analisis Dasar
            $pos = 'Isim';
            $morphology = 'Shighah: Isim Mufrad | Wazan: فِعْلٌ | Bina\': Shahih';
            $irabStatus = 'Mabni/Mu\'rab';
            $irabMarker = 'Harakat Akhir';
            $syntacticRole = 'Kata (Offline)';
            $explanation = 'Analisis dasar lokal offline (API Key Gemini belum diset).';

            if ($isParticle) {
                $pos = 'Huruf';
                $irabStatus = 'Mabni';
                $irabMarker = 'Sukun/Harakat';
                $syntacticRole = 'Huruf ' . ucfirst($particleType);
                
                $chapterTitle = $ref['chapter_title'] ?? 'Huruf Tugas';
                $rulesOfChapter = \App\Models\GrammarRule::where('chapter_id', $ref['chapter_id'] ?? 0)->pluck('rule_text')->toArray();
                if (!empty($rulesOfChapter)) {
                    $explanation = "Kata '{$text}' dideteksi sebagai Huruf {$particleType} sesuai kaidah Jurumiyah: \"" . implode('; ', $rulesOfChapter) . "\".";
                } else {
                    $explanation = "Kata '{$text}' dideteksi sebagai Huruf {$particleType} berdasarkan materi Bab '{$chapterTitle}' Matan Al-Ajurrumiyyah.";
                }
            } else {
                // Cek apakah kata ini adalah Kata Kerja (Fi'il)
                $verbInfo = $this->isWordVerb($text);

                if ($verbInfo) {
                    $pos = 'Fi\'il';
                    $morphology = "Shighah: {$verbInfo['morphology']} | Wazan: " . ($verbInfo['type'] === 'Mudhari' ? 'يَفْعُلُ' : 'فَعَلَ') . " | Bina': Shahih";
                    $irabStatus = $verbInfo['type'] === 'Mudhari' ? 'Rafa\'/Manshub/Majzum' : 'Mabni';
                    $irabMarker = $verbInfo['type'] === 'Madhi' ? 'Fathah' : ($verbInfo['type'] === 'Amr' ? 'Sukun' : 'Dhammah');
                    $syntacticRole = 'Fi\'il (' . $verbInfo['type'] . ')';
                    $explanation = "Kata '{$text}' dideteksi sebagai kata kerja ({$verbInfo['morphology']}) berdasarkan pola morfologi lokal.";
                } else {
                    // Deteksi awalan Alif Lam
                    if (Str::startsWith($text, 'ال')) {
                        $pos = 'Isim';
                        $morphology = 'Shighah: Isim Ma\'rifah | Wazan: اَلْفِعْلُ | Bina\': Shahih';
                    }

                    // Tentukan peran Isim berdasarkan posisi kalimat
                    $isimCount++;

                    // Deteksi kedudukan Majrur bil Harfi jika kata sebelumnya adalah Huruf Jar
                    $prevToken = ($index > 0) ? $tokens[$index - 1] : null;
                    if ($prevToken && ($prevToken['particle_type'] ?? null) === 'jar') {
                        $pos = 'Isim';
                        $irabStatus = 'Jar';
                        $irabMarker = 'Kasrah';
                        $syntacticRole = 'Majrur bil harfi';
                        $explanation = "Kata '{$text}' berstatus Majrur karena didahului oleh huruf jar '{$prevToken['text']}' sesuai kaidah Jurumiyah.";
                    } else {
                        // Heuristik Peran Sintaksis Dasar
                        if ($sentenceType === 'Jumlah Fi\'liyah') {
                            if ($isimCount === 1) {
                                $irabStatus = 'Rafa\'';
                                $irabMarker = 'Dhammah';
                                $syntacticRole = 'Fa\'il (Pelaku)';
                                $explanation = "Kata '{$text}' merupakan Fa'il (subjek pelaku) yang dihukumi Rafa' dengan tanda Dhammah setelah kata kerja aktif.";
                            } elseif ($isimCount === 2) {
                                $irabStatus = 'Nashab';
                                $irabMarker = 'Fathah';
                                $syntacticRole = 'Maf\'ul Bih (Objek)';
                                $explanation = "Kata '{$text}' merupakan Maf'ul Bih (objek penderita) yang dihukumi Nashab dengan tanda Fathah.";
                            }
                        } else { // Jumlah Ismiyah
                            if ($isimCount === 1) {
                                $irabStatus = 'Rafa\'';
                                $irabMarker = 'Dhammah';
                                $syntacticRole = 'Mubtada\'';
                                $explanation = "Kata '{$text}' merupakan Mubtada' (subjek kalimat nominal) yang dihukumi Rafa' dengan tanda Dhammah.";
                            } elseif ($isimCount === 2) {
                                $irabStatus = 'Rafa\'';
                                $irabMarker = 'Dhammah';
                                $syntacticRole = 'Khabar';
                                $explanation = "Kata '{$text}' merupakan Khabar (predikat penjelas Mubtada') yang dihukumi Rafa' dengan tanda Dhammah.";
                            }
                        }
                    }
                }
            }

            $wordAnalysis[] = [
                'word' => $text,
                'vocalized_word' => $text,
                'part_of_speech' => $pos,
                'morphology' => $morphology,
                'irab_status' => $irabStatus,
                'irab_marker' => $irabMarker,
                'syntactic_role' => $syntacticRole,
                'explanation' => $explanation,
                'jurumiyah_reference_code' => $ref['chapter_title'] ?? null
            ];
        }

        return [
            'sentence_structure' => $sentenceType,
            'vocalized_sentence' => $sentence,
            'word_by_word_analysis' => $wordAnalysis
        ];
    }

    /**
     * Memeriksa apakah kata merupakan Fi'il (Kata Kerja) secara lokal gundul.
     */
    protected function isWordVerb(string $text): ?array
    {
        $normalizer = new \App\Services\Nlp\ArabicNormalizerService();
        $gundul = $normalizer->stripDiacritics($text);

        // Penanda Isim absolut: diawali Alif Lam atau diakhiri Ta Marbutah
        if (Str::startsWith($gundul, 'ال') || Str::endsWith($gundul, 'ة')) {
            return null;
        }

        // Diakhiri tanwin
        if (preg_match('/[\x{064B}\x{064C}\x{064D}]$/u', $text)) {
            return null;
        }

        $commonVerbs = [
            'ضرب', 'قام', 'ذهب', 'جاء', 'جلس', 'أكل', 'مر', 'تصبب', 'انطلق', 'استخرج', 
            'خلق', 'ولد', 'كتب', 'سافر', 'ظن', 'حسب', 'خal', 'زعم', 'رأى', 'علم', 
            'وجد', 'اتخذ', 'جعل', 'سمع', 'كان', 'صار', 'أصبح', 'أمسى', 'أضحى', 'ظل', 
            'بات', 'زال', 'فتئ', 'انفك', 'برح', 'دام', 'ليس', 'قال', 'أراد', 'شاء',
            'يقom', 'يضرب', 'يذهب', 'يجيء', 'يجلس', 'يأكل', 'يمر', 'يكتب', 'يظن', 'يجعل',
            'يرى', 'يكون', 'تكون', 'أكون', 'نكون', 'يقول', 'يقولون', 'قل'
        ];
        $commonVerbs[16] = 'خال';
        $commonVerbs[33] = 'يقوم';

        if (in_array($gundul, $commonVerbs)) {
            if (Str::startsWith($gundul, ['ي', 'ت', 'أ', 'ن']) && mb_strlen($gundul) >= 4) {
                return ['type' => 'Mudhari', 'morphology' => 'Fi\'il Mudhari\' (Kata Kerja Sedang/Akan Datang)'];
            }
            if (in_array($gundul, ['قل', 'اضرب', 'قم', 'اذهب'])) {
                return ['type' => 'Amr', 'morphology' => 'Fi\'il Amr (Kata Kerja Perintah)'];
            }
            return ['type' => 'Madhi', 'morphology' => 'Fi\'il Madhi (Kata Kerja Lampau)'];
        }

        if (in_array(mb_substr($gundul, 0, 1), ['ي', 'ت', 'أ', 'ن']) && mb_strlen($gundul) >= 4) {
            return ['type' => 'Mudhari', 'morphology' => 'Fi\'il Mudhari\' (Kata Kerja Sedang/Akan Datang)'];
        }

        if (Str::endsWith($gundul, ['ت', 'نا', 'وا', 'تم'])) {
            return ['type' => 'Madhi', 'morphology' => 'Fi\'il Madhi (Kata Kerja Lampau)'];
        }

        return null;
    }
}
