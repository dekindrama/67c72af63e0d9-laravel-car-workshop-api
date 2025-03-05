<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\RepairCar;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairOnlySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carOwner = User::where('role', RoleEnum::CAR_OWNER)->first();
        $repair = Repair::factory()->create([
            'owner_id' => $carOwner->id,
        ]);

        $car = RepairCar::factory()->create([
            'repair_id' => $repair->id,
        ]);
    }
}
