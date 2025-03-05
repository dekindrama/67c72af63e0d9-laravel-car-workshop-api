<?php

namespace Tests\Feature\Admin\Repair\RepairController;

use App\Enums\RepairStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\RepairCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        $this->seed();

        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $owner = User::where('role', RoleEnum::CAR_OWNER)->first();

        $requestData = [
            'owner_id' => $owner->id,
            'status' => RepairStatusEnum::PROGRESS,
            'car_number_plate' => 'B 1234 XYZ',
            'car_description' => 'Red sedan, minor scratches'
        ];

        $response = $this->actingAs($admin)->postJson(route('admin.repair.store'), $requestData);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'repair' => ['id', 'status', 'arrived_at']
                     ]
                 ]);

        $this->assertDatabaseHas(Repair::class, [
            'owner_id' => $owner->id,
            'status' => RepairStatusEnum::PROGRESS
        ]);

        $this->assertDatabaseHas(RepairCar::class, [
            'number_plate' => 'B 1234 XYZ',
            'description' => 'Red sedan, minor scratches'
        ]);
    }
}
