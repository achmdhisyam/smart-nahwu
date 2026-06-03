<?php

namespace Database\Factories;

use App\Models\BabJurumiyah;
use Illuminate\Database\Eloquent\Factories\Factory;

class BabJurumiyahFactory extends Factory
{
    protected $model = BabJurumiyah::class;

    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(),
            'definisi' => $this->faker->paragraph(),
            'nomor_urut' => $this->faker->randomNumber(2),
            'langkah_belajar' => $this->faker->randomNumber(1),
        ];
    }
}
