<?php

namespace Database\Factories;

use App\Models\GeneratedQuiz;
use App\Models\QuizHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizHistory>
 */
class QuizHistoryFactory extends Factory
{
    protected $model = QuizHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'quiz_id' => GeneratedQuiz::factory(),
            'score' => $this->faker->randomFloat(2, 0, 100),
            'answers_data' => [
                [
                    'question_id' => 1,
                    'user_selected' => 'A',
                    'correct_answer' => 'A',
                    'is_correct' => true
                ]
            ],
        ];
    }
}
