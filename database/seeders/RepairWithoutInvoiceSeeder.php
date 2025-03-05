<?php

namespace Database\Seeders;

use App\Enums\RepairJobStatusEnum;
use App\Enums\RoleEnum;
use App\Helpers\RepairInvoiceHelper;
use App\Models\Repair;
use App\Models\RepairCar;
use App\Models\RepairInvoice;
use App\Models\RepairJob;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepairWithoutInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carOwner = User::where('role', RoleEnum::CAR_OWNER)->first();
        $mechanic = User::where('role', RoleEnum::MECHANIC)->first();
        $service = Service::take(2)->get();

        $repair = Repair::factory()->create([
            'owner_id' => $carOwner->id,
        ]);

        $car = RepairCar::factory()->create([
            'repair_id' => $repair->id,
        ]);

        $job = RepairJob::factory()->create([
            'service_id' => $service[0]->id,
            'repair_id' => $repair->id,
            'mechanic_id' => $mechanic->id,
            'status' => RepairJobStatusEnum::COMPLETED,
        ]);
        $job = RepairJob::factory()->create([
            'service_id' => $service[1]->id,
            'repair_id' => $repair->id,
            'mechanic_id' => $mechanic->id,
            'status' => RepairJobStatusEnum::COMPLETED,
        ]);
    }
}
