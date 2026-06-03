<?php

namespace App\Services\Learning;

use App\Models\JurumiyahChapter;
use App\Models\UserProgress;

class LearningPathService
{
    /**
     * Mendapatkan status kemajuan belajar total siswa.
     *
     * @param int $userId
     * @return array
     */
    public function getProgressStats(int $userId): array
    {
        $totalChapters = JurumiyahChapter::count();
        if ($totalChapters === 0) {
            return ['completed' => 0, 'total' => 0, 'percentage' => 0];
        }

        $masteredCount = UserProgress::where('user_id', $userId)
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
     * @return JurumiyahChapter|null
     */
    public function getRecommendation(int $userId): ?JurumiyahChapter
    {
        // Temukan chapter dengan learning_step terkecil yang belum 'mastered' (skor >= 80)
        return JurumiyahChapter::whereNotExists(function ($query) use ($userId) {
            $query->select('*')
                ->from('user_progress')
                ->whereColumn('user_progress.chapter_id', 'jurumiyah_chapters.id')
                ->where('user_progress.user_id', $userId)
                ->where('user_progress.status', 'mastered');
        })
        ->orderBy('learning_step')
        ->orderBy('order_num')
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
        $chapters = JurumiyahChapter::orderBy('learning_step')
            ->orderBy('order_num')
            ->get();

        $progressMap = UserProgress::where('user_id', $userId)
            ->get()
            ->keyBy('chapter_id');

        return $chapters->map(function ($chapter) use ($progressMap) {
            $progress = $progressMap->get($chapter->id);
            
            $chapter->progress_status = $progress ? $progress->status : 'locked';
            $chapter->best_score = $progress ? $progress->best_score : null;
            $chapter->attempts = $progress ? $progress->attempts_count : 0;

            return $chapter;
        });
    }
}
