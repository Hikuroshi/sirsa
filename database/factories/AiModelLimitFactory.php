<?php

namespace Database\Factories;

use App\Models\AiModelLimit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AiModelLimit>
 */
class AiModelLimitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider' => fake()->unique()->slug(1),
            'model' => fake()->unique()->slug(2),
            'rpm' => 10,
            'rpd' => 250,
            'tpm' => 250000,
        ];
    }
}
