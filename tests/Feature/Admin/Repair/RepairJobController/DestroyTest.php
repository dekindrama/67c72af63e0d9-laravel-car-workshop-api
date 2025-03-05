<?php

namespace Tests\Feature\Admin\Repair\RepairJobController;

use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\RepairJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_destroy()
    {
        $this->seed();
        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $repair = Repair::first();
        $job = $repair->jobs->first();

        $response = $this->actingAs($admin)->deleteJson(route('admin.repair.repair-job.destroy', [
            'id' => $repair->id,
            'repair_job_id' => $job->id,
        ]));

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing(RepairJob::class, [
            'id' => $job->id,
        ]);
    }
}
