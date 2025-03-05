<?php

namespace Database\Factories;

use App\Enums\RepairStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repair>
 */
class RepairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => 1,
            'status' => RepairStatusEnum::COMPLETED,
            'arrived_at' => now(),
        ];
    }
}
