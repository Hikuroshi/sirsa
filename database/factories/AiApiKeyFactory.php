<?php

namespace Database\Factories;

use App\Models\AiApiKey;
use App\Models\AiModelLimit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AiApiKey>
 */
class AiApiKeyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'ai_model_limit_id' => AiModelLimit::factory(),
            'secret' => 'test-api-key-'.fake()->uuid(),
            'suffix' => fake()->numerify('####'),
            'priority' => 100,
            'is_active' => true,
            'failure_count' => 0,
        ];
    }
}
