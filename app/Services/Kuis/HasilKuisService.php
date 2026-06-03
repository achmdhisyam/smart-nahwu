<?php

namespace App\Services\Kuis;

use App\Models\BuatKuis;
use App\Models\RiwayatKuis;
use App\Models\ProgresPengguna;
use App\Services\Pembelajaran\PencapaianService;

class HasilKuisService
{
    protected $pencapaianService;

    public function __construct(PencapaianService $pencapaianService)
    {
        $this->pencapaianService = $pencapaianService;
    }

    /**
     * Memeriksa dan menilai jawaban kuis secara otomatis, lalu menyimpan hasilnya ke DB.
     *
     * @param BuatKuis $quiz
     * @param array $userAnswers Key adalah ID Pertanyaan, Value adalah ID Opsi yang dipilih (A, B, C, D)
     * @param int $userId
     * @return RiwayatKuis
     */
    public function gradeAndSave(BuatKuis $quiz, array $userAnswers, int $userId): RiwayatKuis
    {
        $questions = $quiz->data_pertanyaan['questions'] ?? [];
        $totalQuestions = count($questions);
        $correctCount = 0;
        
        $answersDetails = [];

        foreach ($questions as $q) {
            $qId = $q['id'];
            $correctAnswer = $q['correct_answer'];
            $selectedAnswer = $userAnswers[$qId] ?? null;

            $isCorrect = ($selectedAnswer === $correctAnswer);
            if ($isCorrect) {
                $correctCount++;
            }

            $answersDetails[] = [
                'question_id' => $qId,
                'question_text' => $q['question'],
                'user_selected' => $selectedAnswer,
                'correct_answer' => $correctAnswer,
                'is_correct' => $isCorrect,
                'explanation' => $q['explanation'] ?? '',
            ];
        }

        // Hitung skor (0 - 100)
        $score = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;
        $roundedScore = round($score, 2);

        // 1. Simpan ke riwayat nilai database
        $attempt = RiwayatKuis::create([
            'user_id' => $userId,
            'kuis_id' => $quiz->id,
            'skor' => $roundedScore,
            'data_jawaban' => $answersDetails,
        ]);

        // 2. Perbarui progress belajar bab (User Progress)
        $progress = ProgresPengguna::firstOrNew([
            'user_id' => $userId,
            'bab_id' => $quiz->bab_id,
        ]);

        $progress->jumlah_percobaan += 1;
        $progress->skor_terbaik = max($progress->skor_terbaik ?? 0, $roundedScore);

        // Kriteria Mastered jika skor terbaik mencapai >= 80
        if ($progress->skor_terbaik >= 80.00) {
            $progress->status = 'mastered';
        } else {
            $progress->status = 'learning';
        }
        $progress->save();

        // 3. Periksa dan berikan pencapaian jika memenuhi kriteria
        $this->pencapaianService->checkAndAward($userId, $attempt);

        return $attempt;
    }
}
