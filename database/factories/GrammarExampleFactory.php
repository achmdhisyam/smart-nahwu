<?php

namespace Database\Factories;

use App\Models\GrammarExample;
use App\Models\JurumiyahChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrammarExample>
 */
class GrammarExampleFactory extends Factory
{
    protected $model = GrammarExample::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chapter_id' => JurumiyahChapter::factory(),
            'arabic_text' => 'جَاءَ زَيْدٌ',
            'translation' => 'Zaid telah datang.',
        ];
    }
}
