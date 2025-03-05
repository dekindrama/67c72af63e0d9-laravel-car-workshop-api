<?php

namespace Tests\Feature\Admin\Repair\RepairInvoiceController;

use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\User;
use Database\Seeders\RepairWithInvoiceSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_show(): void
    {
        $this->seed([
            UserSeeder::class,
            ServiceSeeder::class,
            RepairWithInvoiceSeeder::class,
        ]);
        $repair = Repair::first();
        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $response = $this->actingAs($admin)->getJson(route('admin.repair.repair-invoice.show', $repair->id));

        $response->assertStatus(Response::HTTP_OK)
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
