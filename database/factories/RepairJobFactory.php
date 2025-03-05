<?php

namespace Database\Factories;

use App\Enums\RepairJobStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RepairJob>
 */
class RepairJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'repair_id' => 1,
            'service_id' => 1,
            'mechanic_id' => 1,
            'status' => RepairJobStatusEnum::UNASSIGNED,
        ];
    }
}
