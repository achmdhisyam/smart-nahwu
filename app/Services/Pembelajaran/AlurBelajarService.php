<?php

namespace App\Services\Pembelajaran;

use App\Models\BabJurumiyah;
use App\Models\ProgresPengguna;

class AlurBelajarService
{
    /**
     * Mendapatkan status kemajuan belajar total siswa.
     *
     * @param int $userId
     * @return array
     */
    public function getProgressStats(int $userId): array
    {
        $totalChapters = BabJurumiyah::count();
        if ($totalChapters === 0) {
            return ['completed' => 0, 'total' => 0, 'percentage' => 0];
        }

        $masteredCount = ProgresPengguna::where('user_id', $userId)
            ->where('status', 'mastered')
            ->count();

        return [
            'completed' => $masteredCount,
            'total' => $totalChapters,
            'percentage' => round(($masteredCount / $totalChapters) * 100, 1),
        ];
    }

    /**
     * Merekomendasikan bab pembelajaran berikutnya berdasarkan progress siswa saat ini.
     *
     * @param int $userId
     * @return BabJurumiyah|null
     */
    public function getRecommendation(int $userId): ?BabJurumiyah
    {
        // Temukan bab dengan langkah_belajar terkecil yang belum 'mastered' (skor >= 80)
        return BabJurumiyah::whereNotExists(function ($query) use ($userId) {
            $query->select('*')
                ->from('progres_pengguna')
                ->whereColumn('progres_pengguna.bab_id', 'bab_jurumiyah.id')
                ->where('progres_pengguna.user_id', $userId)
                ->where('progres_pengguna.status', 'mastered');
        })
        ->orderBy('langkah_belajar')
        ->orderBy('nomor_urut')
        ->first();
    }

    /**
     * Mengambil daftar seluruh bab beserta status belajar saat ini untuk siswa.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChaptersWithProgress(int $userId)
    {
        $chapters = BabJurumiyah::orderBy('langkah_belajar')
            ->orderBy('nomor_urut')
            ->get();

        $progressMap = ProgresPengguna::where('user_id', $userId)
            ->get()
            ->keyBy('bab_id');

        return $chapters->map(function ($chapter) use ($progressMap) {
            $progress = $progressMap->get($chapter->id);
            
            $chapter->progress_status = $progress ? $progress->status : 'locked';
            $chapter->best_score = $progress ? $progress->skor_terbaik : null;
            $chapter->attempts = $progress ? $progress->jumlah_percobaan : 0;

            return $chapter;
        });
    }
}
