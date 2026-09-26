<?php

namespace Database\Factories;

use App\Enums\ReportStatus;
use App\Models\Report;
use App\Models\ReportStatusHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReportStatusHistory>
 */
class ReportStatusHistoryFactory extends Factory
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
            'from_status' => null,
            'to_status' => ReportStatus::Accepted,
            'note' => fake()->sentence(),
        ];
    }
}
