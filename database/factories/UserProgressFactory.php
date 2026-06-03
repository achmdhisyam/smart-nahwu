<?php

namespace Database\Factories;

use App\Models\JurumiyahChapter;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProgress>
 */
class UserProgressFactory extends Factory
{
    protected $model = UserProgress::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'chapter_id' => JurumiyahChapter::factory(),
            'status' => $this->faker->randomElement(['locked', 'learning', 'mastered']),
            'attempts_count' => $this->faker->numberBetween(0, 10),
            'best_score' => $this->faker->randomFloat(2, 0, 100),
            'last_attempt_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
