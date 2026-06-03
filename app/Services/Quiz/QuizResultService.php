<?php

namespace App\Services\Quiz;

use App\Models\GeneratedQuiz;
use App\Models\QuizHistory;
use App\Models\UserProgress;
use App\Services\Learning\AchievementService;

class QuizResultService
{
    protected $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    /**
     * Memeriksa dan menilai jawaban kuis secara otomatis, lalu menyimpan hasilnya ke DB.
     *
     * @param GeneratedQuiz $quiz
     * @param array $userAnswers Key adalah ID Pertanyaan, Value adalah ID Opsi yang dipilih (A, B, C, D)
     * @param int $userId
     * @return QuizHistory
     */
    public function gradeAndSave(GeneratedQuiz $quiz, array $userAnswers, int $userId): QuizHistory
    {
        $questions = $quiz->questions_data['questions'] ?? [];
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
        $attempt = QuizHistory::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
            'score' => $roundedScore,
            'answers_data' => $answersDetails,
        ]);

        // 2. Perbarui progress belajar bab (User Progress)
        $progress = UserProgress::firstOrNew([
            'user_id' => $userId,
            'chapter_id' => $quiz->chapter_id,
        ]);

        $progress->attempts_count += 1;
        $progress->best_score = max($progress->best_score ?? 0, $roundedScore);
        $progress->last_attempt_at = now();

        // Kriteria Mastered jika skor terbaik mencapai >= 80
        if ($progress->best_score >= 80.00) {
            $progress->status = 'mastered';
        } else {
            $progress->status = 'learning';
        }
        $progress->save();

        // 3. Periksa dan berikan lencana pencapaian jika memenuhi kriteria
        $this->achievementService->checkAndAward($userId, $attempt);

        return $attempt;
    }
}
