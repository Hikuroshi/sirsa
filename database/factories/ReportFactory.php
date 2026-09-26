<?php

namespace Database\Factories;

use App\Enums\AiStatus;
use App\Enums\ReportPriority;
use App\Enums\ReportStatus;
use App\Models\Organization;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'tracking_code' => Str::lower(Str::random(24)),
            'reporter_name' => fake()->name(),
            'reporter_contact' => fake()->safeEmail(),
            'original_description' => fake()->paragraph(),
            'description' => fake()->paragraph(),
            'priority' => ReportPriority::Medium,
            'status' => ReportStatus::Accepted,
            'ai_status' => AiStatus::Disabled,
        ];
    }
}
