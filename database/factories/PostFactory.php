<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'link' => $this->faker->url,
            'points' => $this->faker->numberBetween(0, 200),
            'origin_date' => now(),
            'origin_id' => $this->faker->numberBetween(1, 10000),
        ];
    }
}
