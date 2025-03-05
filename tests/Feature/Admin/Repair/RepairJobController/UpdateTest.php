<?php

namespace Tests\Feature\Admin\Repair\RepairJobController;

use App\Enums\RepairJobStatusEnum;
use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\RepairJob;
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
        $repair = Repair::first();
        $job = $repair->jobs->first();

        $request = [
            'repair_id' => $job->repair_id,
            'service_id' => $job->service_id,
            'mechanic_id' => $job->mechanic_id,
            'status' => RepairJobStatusEnum::COMPLETED,
        ];

        $response = $this->actingAs($admin)->putJson(route('repair.repair-job.update', [
            'id' => $repair->id,
            'repair_job_id' => $job->id,
        ]), $request);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'job' => ['id', 'status']
                     ]
                 ]);
        $this->assertDatabaseHas(RepairJob::class, $request);
    }
}
