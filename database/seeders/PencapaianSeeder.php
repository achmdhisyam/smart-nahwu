<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'code' => 'ACH_FIRST_QUIZ',
                'title' => 'Langkah Pertama 🏅',
                'description' => 'Menyelesaikan kuis pertama Anda di Smart Nahwu.',
                'badge_icon' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ACH_SCORE_100',
                'title' => 'Sempurna! 🌟',
                'description' => 'Mendapatkan nilai 100 pada kuis latihan bab apa saja.',
                'badge_icon' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ACH_JURUMIYAH_COMPLETED',
                'title' => 'Al-Ajurrumiy Master 🎓',
                'description' => 'Menguasai seluruh bab Kitab Matan Al-Ajurrumiyyah dengan status Mastered.',
                'badge_icon' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($achievements as $achievement) {
            DB::table('achievements')->updateOrInsert(
                ['code' => $achievement['code']],
                $achievement
            );
        }
    }
}
