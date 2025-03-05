<?php

namespace Tests\Feature\Admin\Repair\RepairJobController;

use App\Enums\RepairJobStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\RepairJob;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\RepairOnlySeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        $this->seed([UserSeeder::class, RepairOnlySeeder::class, ServiceSeeder::class]);
        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $mechanic = User::where('role', RoleEnum::MECHANIC)->first();
        $service = Service::first();
        $repair = Repair::first();

        $request = [
            'id' => $repair->id,
            'service_id' => $service->id,
            'mechanic_id' => $mechanic->id,
            'status' => RepairJobStatusEnum::PROGRESS,
        ];

        $response = $this->actingAs($admin)->postJson(route('repair.repair-job.store', [
            'id' => $repair->id,
        ]), $request);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'job' => ['id', 'status']
                     ]
                 ]);
    }
}
