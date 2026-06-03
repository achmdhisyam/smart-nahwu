<?php

namespace Database\Factories;

use App\Models\AnalysisHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnalysisHistory>
 */
class AnalysisHistoryFactory extends Factory
{
    protected $model = AnalysisHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'text_hash' => hash('sha256', $this->faker->unique()->sentence),
            'input_text' => 'جَاءَ زَيْدٌ',
            'analysis_result' => [
                'sentence_structure' => "Jumlah Fi'liyah",
                'word_by_word_analysis' => []
            ],
        ];
    }
}
