<?php

namespace Tests\Feature\Helpers\RepairInvoiceHelper;

use App\Entities\SummaryInvoiceEntity;
use App\Enums\RoleEnum;
use App\Helpers\RepairInvoiceHelper;
use App\Models\Repair;
use App\Models\User;
use Database\Seeders\RepairWithInvoiceSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class setSummaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_run(): void
    {
        $this->seed([
            UserSeeder::class,
            ServiceSeeder::class,
            RepairWithInvoiceSeeder::class,
        ]);
        $repair = Repair::first();
        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $carOwner = User::where('role', RoleEnum::CAR_OWNER)->first();
        $summary = RepairInvoiceHelper::setSummary($repair);
        $totalPrice = 0;
        foreach ($repair->jobs as $index => $job) {
            $totalPrice += $job->service->price;
        }

        $this->assertEquals($carOwner->name, $summary->owner->name);
        $this->assertEquals($carOwner->email, $summary->owner->email);
        $this->assertEquals($repair->car->number_plate, $summary->car_number_plate);
        $this->assertEquals($totalPrice, $summary->total_price);
    }
}
