<?php

namespace App\Services\Quiz;

use App\Models\GeneratedQuiz;
use App\Models\JurumiyahChapter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class QuizGeneratorService
{
    /**
     * Menggenerasi kuis pilihan ganda berdasarkan materi bab Jurumiyah menggunakan Gemini AI.
     *
     * @param JurumiyahChapter $chapter
     * @return GeneratedQuiz
     */
    public function generate(JurumiyahChapter $chapter): GeneratedQuiz
    {
        // 1. Cek apakah kuis untuk bab ini sudah pernah dibuat sebelumnya
        $existingQuiz = GeneratedQuiz::where('chapter_id', $chapter->id)->first();
        if ($existingQuiz) {
            return $existingQuiz;
        }

        // 2. Jika belum ada, buat prompt dengan menyertakan teks materi dan contoh dari bab
        $chapterContent = "Bab: {$chapter->title}\nDefinisi: {$chapter->definition}\n";
        
        $rulesText = "";
        foreach ($chapter->grammarRules as $rule) {
            $rulesText .= "- {$rule->rule_text}\n";
        }
        
        $examplesText = "";
        foreach ($chapter->grammarExamples as $example) {
            $examplesText .= "- Arab: {$example->arabic_text}, Terjemahan: {$example->translation}\n";
        }

        $prompt = $this->buildQuizPrompt($chapter->title, $chapterContent . $rulesText . $examplesText);

        // 3. Panggil Gemini API
        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            // Fallback: Jika API Key tidak ada, buat kuis mock agar aplikasi tidak crash
            return $this->createFallbackQuiz($chapter);
        }

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key={$apiKey}";

        try {
            $response = Http::retry(3, 100)
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
                throw new \RuntimeException("Gemini API gagal memproses pembuatan kuis.");
            }

            $result = $response->json();
            $rawJson = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            // Bersihkan markdown jika LLM membungkusnya
            $cleanJson = preg_replace('/^```(?:json)?\s+/iu', '', trim($rawJson));
            $cleanJson = preg_replace('/\s+```$/u', '', $cleanJson);

            $quizData = json_decode($cleanJson, true);

            if (json_last_error() !== JSON_ERROR_NONE || !isset($quizData['questions'])) {
                throw new \RuntimeException("Format output kuis dari AI tidak valid.");
            }

            // 4. Simpan kuis yang digenerasi ke database
            return GeneratedQuiz::create([
                'chapter_id' => $chapter->id,
                'title' => 'Latihan Soal: ' . $chapter->title,
                'questions_data' => $quizData,
            ]);

        } catch (\Exception $e) {
            Log::error("Quiz Generation Failed: " . $e->getMessage());
            return $this->createFallbackQuiz($chapter);
        }
    }

    /**
     * Membangun prompt instruksi kuis ke Gemini.
     */
    protected function buildQuizPrompt(string $chapterTitle, string $context): string
    {
        return <<<PROMPT
Anda adalah ahli penyusun soal ujian Bahasa Arab klasik yang sangat teliti dan profesional.
Tugas Anda adalah membuat 5 soal pilihan ganda (opsi A, B, C, D) yang berkualitas tinggi berdasarkan kaidah Kitab Matan Al-Ajurrumiyyah berikut:

Materi Rujukan:
{$context}

ATURAN WAJIB SOAL KUIS (MENCEGAH AMBIGU):
1. **Hanya Gunakan Contoh Arab dari Konteks**: Soal WAJIB hanya dibuat menggunakan kalimat-kalimat contoh bahasa Arab yang tercantum di dalam "Materi Rujukan" di atas. JANGAN mengarang atau membuat kalimat Arab baru di luar materi rujukan agar siswa tidak kebingungan.
2. **Harakat Lengkap**: Teks Arab dalam pertanyaan maupun pilihan jawaban wajib diberi harakat secara lengkap dan benar.
3. **Satu Jawaban Mutlak**: Setiap soal hanya boleh memiliki satu opsi yang benar secara mutlak. Tiga opsi pengecoh harus salah secara tata bahasa (misalnya salah status I'rab, salah tanda I'rab, atau salah harakat akhir).
4. **Gunakan Pola Soal Terstandar Berikut**:
   - Pola 1 (Kedudukan): Menanyakan kedudukan tata bahasa suatu kata dalam kalimat contoh (Contoh: "Pada kalimat '...', kata '...' berkedudukan sebagai apa?").
   - Pola 2 (Tanda I'rab): Menanyakan tanda I'rab dari suatu kata (Contoh: "Apa tanda I'rab rafa' pada kata '...' dalam kalimat '...'?").
   - Pola 3 (Alasan I'rab): Menanyakan alasan status I'rab (Contoh: "Mengapa kata '...' berstatus majrur/jar pada kalimat '...'?").
   - Pola 4 (Klasifikasi Kata): Menanyakan jenis kata (Contoh: "Dalam kalimat '...', kata '...' termasuk jenis kata apa (Isim, Fi'il, atau Huruf)?").

Format Output (JSON Valid Tanpa Markdown):
{
  "questions": [
    {
      "id": 1,
      "question": "Teks pertanyaan berpola jelas dan berharakat lengkap",
      "options": [
        {"id": "A", "text": "Opsi A"},
        {"id": "B", "text": "Opsi B"},
        {"id": "C", "text": "Opsi C"},
        {"id": "D", "text": "Opsi D"}
      ],
      "correct_answer": "A" atau "B" atau "C" atau "D",
      "explanation": "Penjelasan logis dan ringkas tentang mengapa pilihan tersebut benar secara kaidah tata bahasa Arab."
    }
  ]
}
PROMPT;
    }

    /**
     * Membuat kuis cadangan jika koneksi AI gagal.
     */
    protected function createFallbackQuiz(JurumiyahChapter $chapter): GeneratedQuiz
    {
        $mockQuestions = [
            'questions' => [
                [
                    'id' => 1,
                    'question' => "Manakah di bawah ini contoh kalimat yang paling tepat menggambarkan bab: {$chapter->title}?",
                    'options' => [
                        ['id' => 'A', 'text' => 'قَامَ زَيْدٌ (Zaid telah berdiri)'],
                        ['id' => 'B', 'text' => 'كَتَبَ الرَّجُلُ (Pria itu menulis)'],
                        ['id' => 'C', 'text' => 'فِي الْمَدْرَسَةِ (Di sekolah)'],
                        ['id' => 'D', 'text' => 'كِتَابُ زَيْدٍ (Buku Zaid)']
                    ],
                    'correct_answer' => 'A',
                    'explanation' => 'Kalimat قَامَ زَيْدٌ adalah contoh standar dalam Jurumiyah untuk menjelaskan kedudukan isim marfu\'.'
                ]
            ]
        ];

        return GeneratedQuiz::create([
            'chapter_id' => $chapter->id,
            'title' => 'Latihan Soal (Standard): ' . $chapter->title,
            'questions_data' => $mockQuestions,
        ]);
    }
}
