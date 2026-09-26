<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'imageable_id' => Report::factory(),
            'imageable_type' => Report::class,
            'path' => 'reports/example.jpg',
            'sort_order' => 0,
        ];
    }
}
