<?php

namespace App\Services\Quiz;

use App\Models\JurumiyahChapter;
use App\Models\QuizHistory;
use App\Models\GeneratedQuiz;

class QuizService
{
    /**
     * Mengambil seluruh bab beserta relasi kuis dan nilai terbaik siswa saat ini.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChaptersWithQuizScores(int $userId)
    {
        return JurumiyahChapter::with(['generatedQuizzes'])
            ->orderBy('order_num')
            ->get()
            ->map(function ($chapter) use ($userId) {
                // Tambahkan attribute dynamic nilai terbaik user untuk bab ini
                $bestAttempt = null;
                $quiz = $chapter->generatedQuizzes->first();
                
                if ($quiz) {
                    $bestAttempt = QuizHistory::where('quiz_id', $quiz->id)
                        ->where('user_id', $userId)
                        ->max('score');
                }
                
                $chapter->best_score = $bestAttempt;
                return $chapter;
            });
    }

    /**
     * Ambil riwayat nilai kuis terpaginasi milik user.
     */
    public function getUserQuizHistory(int $userId, int $perPage = 10)
    {
        return QuizHistory::with('quiz')
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }
}
