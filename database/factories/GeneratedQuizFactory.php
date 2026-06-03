<?php

namespace Database\Factories;

use App\Models\GeneratedQuiz;
use App\Models\JurumiyahChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeneratedQuiz>
 */
class GeneratedQuizFactory extends Factory
{
    protected $model = GeneratedQuiz::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chapter_id' => JurumiyahChapter::factory(),
            'title' => $this->faker->sentence(3),
            'questions_data' => [
                'questions' => [
                    [
                        'id' => 1,
                        'question' => 'Contoh soal?',
                        'options' => [
                            ['id' => 'A', 'text' => 'Pilihan A'],
                            ['id' => 'B', 'text' => 'Pilihan B']
                        ],
                        'correct_answer' => 'A',
                        'explanation' => 'Penjelasan jawaban benar.'
                    ]
                ]
            ],
        ];
    }
}
