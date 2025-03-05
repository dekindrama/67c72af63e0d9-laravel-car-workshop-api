<?php

namespace Tests\Feature\Admin\Repair\RepairInvoiceController;

use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\User;
use Database\Seeders\RepairOnlySeeder;
use Database\Seeders\RepairWithoutInvoiceSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store(): void
    {
        $this->seed([
            UserSeeder::class,
            ServiceSeeder::class,
            RepairWithoutInvoiceSeeder::class,
        ]);
        $repair = Repair::first();
        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $response = $this->actingAs($admin)->postJson(route('admin.repair.repair-invoice.store', $repair->id));

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'invoice' => [
                        'summary' => ['owner', 'services', 'total_price', 'car_number_plate'],
                    ],
                ],
            ]);
    }
}
