<?php

namespace App\Services\Kuis;

use App\Models\BabJurumiyah;
use App\Models\RiwayatKuis;

class KuisService
{
    /**
     * Mengambil seluruh bab beserta relasi kuis dan nilai terbaik siswa saat ini.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChaptersWithQuizScores(int $userId)
    {
        return BabJurumiyah::with(['buatKuis'])
            ->orderBy('nomor_urut')
            ->get()
            ->map(function ($chapter) use ($userId) {
                // Tambahkan attribute dynamic nilai terbaik user untuk bab ini
                $bestAttempt = null;
                $quiz = $chapter->buatKuis;
                
                if ($quiz) {
                    $bestAttempt = RiwayatKuis::where('kuis_id', $quiz->id)
                        ->where('user_id', $userId)
                        ->max('skor');
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
        return RiwayatKuis::with('kuis')
            ->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }
}
