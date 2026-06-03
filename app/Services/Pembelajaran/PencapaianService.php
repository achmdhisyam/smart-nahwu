<?php

namespace App\Services\Pembelajaran;

use App\Models\Pencapaian;
use App\Models\RiwayatKuis;
use App\Models\User;
use App\Models\ProgresPengguna;

class PencapaianService
{
    /**
     * Memeriksa dan memberikan pencapaian baru pasca pengerjaan kuis siswa.
     *
     * @param int $userId
     * @param RiwayatKuis $attempt
     * @return array<Pencapaian> Pencapaian baru yang berhasil didapatkan
     */
    public function checkAndAward(int $userId, RiwayatKuis $attempt): array
    {
        $user = User::findOrFail($userId);
        $newAchievements = [];

        // 1. Pencapaian: "Sang Pembuka" (Selesaikan Kuis Pertama)
        $this->awardIfEligible($user, 'ACH_FIRST_QUIZ', function () use ($user) {
            return $user->quizHistories()->count() >= 1;
        }, $newAchievements);

        // 2. Pencapaian: "Sempurna" (Skor 100 pada kuis apa pun)
        $this->awardIfEligible($user, 'ACH_SCORE_100', function () use ($attempt) {
            return $attempt->skor >= 100.00;
        }, $newAchievements);

        // 3. Pencapaian: "Lulusan Jurumiyah" (Mastered seluruh bab kuis)
        $this->awardIfEligible($user, 'ACH_JURUMIYAH_COMPLETED', function () use ($userId) {
            $totalChapters = \App\Models\BabJurumiyah::count();
            $masteredChapters = ProgresPengguna::where('user_id', $userId)
                ->where('status', 'mastered')
                ->count();
            return $totalChapters > 0 && $masteredChapters === $totalChapters;
        }, $newAchievements);

        return $newAchievements;
    }

    /**
     * Logika pembagian pencapaian jika memenuhi syarat dan belum memilikinya.
     */
    protected function awardIfEligible(User $user, string $code, callable $criteria, array &$newAchievements): void
    {
        $achievement = Pencapaian::where('kode_pencapaian', $code)->first();

        if ($achievement && !$user->pencapaian()->where('pencapaian_id', $achievement->id)->exists()) {
            if ($criteria()) {
                $user->pencapaian()->attach($achievement->id, ['terbuka_pada' => now()]);
                $newAchievements[] = $achievement;
            }
        }
    }
}
