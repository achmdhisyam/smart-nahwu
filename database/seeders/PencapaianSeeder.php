<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PencapaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'kode_pencapaian' => 'ACH_FIRST_QUIZ',
                'judul' => 'Pena Pertama',
                'deskripsi' => 'Menyelesaikan kuis evaluasi pertama Anda.',
                'ikon_pencapaian' => 'fa-feather-pointed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_pencapaian' => 'ACH_SCORE_100',
                'judul' => 'Mumtaz',
                'deskripsi' => 'Mendapatkan nilai sempurna (100) pada salah satu kuis.',
                'ikon_pencapaian' => 'fa-star',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_pencapaian' => 'ACH_JURUMIYAH_COMPLETED',
                'judul' => 'Khatam Al-Ajurrumiyyah',
                'deskripsi' => 'Menyelesaikan seluruh bab Kitab Matan Al-Ajurrumiyyah.',
                'ikon_pencapaian' => 'fa-scroll',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($achievements as $achievement) {
            DB::table('pencapaian')->updateOrInsert(
                ['kode_pencapaian' => $achievement['kode_pencapaian']],
                $achievement
            );
        }
    }
}
