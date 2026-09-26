<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    public function configure(): static
    {
        return $this->afterCreating(function (Organization $organization): void {
            User::query()->whereKey($organization->created_by)->where('role', Role::Admin->value)->update([
                'organization_id' => $organization->id,
            ]);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'created_by' => User::factory()->admin(),
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->randomNumber(4),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
