<?php

namespace Database\Factories;

use App\Models\ArabicParticle;
use App\Models\JurumiyahChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArabicParticle>
 */
class ArabicParticleFactory extends Factory
{
    protected $model = ArabicParticle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chapter_id' => JurumiyahChapter::factory(),
            'particle_text' => 'مِنْ',
            'particle_type' => $this->faker->randomElement(['jar', 'nashab', 'jazm', 'athaf']),
        ];
    }
}
