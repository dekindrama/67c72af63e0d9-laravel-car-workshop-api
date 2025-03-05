<?php

namespace Tests\Feature\Admin\Repair\RepairController;

use App\Enums\RepairStatusEnum;
use App\Enums\RoleEnum;
use App\Mail\Admin\Repair\RepairCompletedMail;
use App\Models\Repair;
use App\Models\RepairCar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update()
    {
        $this->seed();

        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $owner = User::where('role', RoleEnum::CAR_OWNER)->first();
        $repair = Repair::first();

        $request = [
            'id' => $repair->id,
            'owner_id' => $owner->id,
            'status' => RepairStatusEnum::PROGRESS,
            'car_number_plate' => 'B 5678 ABC',
            'car_description' => 'Blue hatchback'
        ];

        $response = $this->actingAs($admin)->putJson(route('admin.repair.update', $repair->id), $request);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'repair' => ['id', 'status', 'arrived_at']
                     ]
                 ]);

        $this->assertDatabaseHas(Repair::class, [
            'id' => $repair->id,
            'status' => RepairStatusEnum::PROGRESS
        ]);

        $this->assertDatabaseHas(RepairCar::class, [
            'number_plate' => 'B 5678 ABC',
            'description' => 'Blue hatchback'
        ]);

        $mailable = new RepairCompletedMail($repair);
        $mailable->assertTo($owner->email);
    }
}
