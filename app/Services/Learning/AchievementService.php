<?php

namespace App\Services\Learning;

use App\Models\Achievement;
use App\Models\QuizHistory;
use App\Models\User;
use App\Models\UserProgress;

class AchievementService
{
    /**
     * Memeriksa dan memberikan lencana baru pasca pengerjaan kuis siswa.
     *
     * @param int $userId
     * @param QuizHistory $attempt
     * @return array<Achievement> Lencana baru yang berhasil didapatkan
     */
    public function checkAndAward(int $userId, QuizHistory $attempt): array
    {
        $user = User::findOrFail($userId);
        $newAchievements = [];

        // 1. Lencana: "Sang Pembuka" (Selesaikan Kuis Pertama)
        $this->awardIfEligible($user, 'ACH_FIRST_QUIZ', function () use ($user) {
            return $user->quizHistories()->count() >= 1;
        }, $newAchievements);

        // 2. Lencana: "Sempurna" (Skor 100 pada kuis apa pun)
        $this->awardIfEligible($user, 'ACH_SCORE_100', function () use ($attempt) {
            return $attempt->score >= 100.00;
        }, $newAchievements);

        // 3. Lencana: "Lulusan Jurumiyah" (Mastered seluruh bab kuis)
        $this->awardIfEligible($user, 'ACH_JURUMIYAH_COMPLETED', function () use ($userId) {
            $totalChapters = \App\Models\JurumiyahChapter::count();
            $masteredChapters = UserProgress::where('user_id', $userId)
                ->where('status', 'mastered')
                ->count();
            return $totalChapters > 0 && $masteredChapters === $totalChapters;
        }, $newAchievements);

        return $newAchievements;
    }

    /**
     * Logika pembagian lencana jika memenuhi syarat dan belum memilikinya.
     */
    protected function awardIfEligible(User $user, string $code, callable $criteria, array &$newAchievements): void
    {
        $achievement = Achievement::where('code', $code)->first();

        if ($achievement && !$user->achievements()->where('achievement_id', $achievement->id)->exists()) {
            if ($criteria()) {
                $user->achievements()->attach($achievement->id, ['unlocked_at' => now()]);
                $newAchievements[] = $achievement;
            }
        }
    }
}
