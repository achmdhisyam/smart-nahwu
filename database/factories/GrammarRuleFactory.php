<?php

namespace Database\Factories;

use App\Models\GrammarRule;
use App\Models\JurumiyahChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrammarRule>
 */
class GrammarRuleFactory extends Factory
{
    protected $model = GrammarRule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chapter_id' => JurumiyahChapter::factory(),
            'rule_code' => 'RULE_' . strtoupper($this->faker->unique()->word()),
            'rule_text' => $this->faker->sentence(10),
        ];
    }
}
