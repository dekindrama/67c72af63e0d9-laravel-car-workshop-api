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
        $carOwner = User::factory()->create([
            'name' => 'owner 2',
            'email' => 'owner2@example.com',
            'role' => RoleEnum::CAR_OWNER,
        ]);
        $mechanic = User::where('role', RoleEnum::MECHANIC)->first();
        $service = Service::take(2)->get();

        $repair = Repair::factory()->create([
            'owner_id' => $carOwner->id,
        ]);

        $car = RepairCar::factory()->create([
            'repair_id' => $repair->id,
        ]);
    }
}
