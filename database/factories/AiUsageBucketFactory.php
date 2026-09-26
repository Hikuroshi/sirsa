<?php

namespace Database\Factories;

use App\Models\AiApiKey;
use App\Models\AiUsageBucket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AiUsageBucket>
 */
class AiUsageBucketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ai_api_key_id' => AiApiKey::factory(),
            'window' => 'minute',
            'period_started_at' => now()->startOfMinute(),
            'requests' => 0,
            'tokens' => 0,
        ];
    }
}
