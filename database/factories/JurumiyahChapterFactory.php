<?php

namespace Database\Factories;

use App\Models\JurumiyahChapter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JurumiyahChapter>
 */
class JurumiyahChapterFactory extends Factory
{
    protected $model = JurumiyahChapter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'title' => $this->faker->sentence(2),
            'definition' => $this->faker->paragraph(),
            'order_num' => $this->faker->numberBetween(1, 100),
        ];
    }
}
