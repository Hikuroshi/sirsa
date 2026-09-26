<?php

namespace Database\Factories;

use App\Enums\ReportPriority;
use App\Models\AiApiKey;
use App\Models\Report;
use App\Models\ReportAiResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReportAiResult>
 */
class ReportAiResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'report_id' => Report::factory(),
            'ai_api_key_id' => AiApiKey::factory(),
            'refined_description' => fake()->paragraph(),
            'priority' => ReportPriority::Medium,
            'reason' => fake()->sentence(),
            'provider' => fake()->slug(1),
            'model' => fake()->slug(2),
            'input_tokens' => 100,
            'output_tokens' => 50,
            'response' => [],
        ];
    }
}
