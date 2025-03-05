<?php

namespace Tests\Feature\Mechanic\Job\JobController;

use App\Enums\RepairJobStatusEnum;
use App\Enums\RoleEnum;
use App\Models\RepairJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_show()
    {
        $this->seed();

        $mechanic = User::where('role', RoleEnum::MECHANIC)->first();
        $job = RepairJob::query()
            ->where('mechanic_id', $mechanic->id)
            ->whereNot('status', RepairJobStatusEnum::COMPLETED)
            ->first();

        $response = $this->actingAs($mechanic)->putJson(route('mechanic.job.update', $job->id), [
            'status' => RepairJobStatusEnum::COMPLETED,
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'job'
                ],
            ]);
        $this->assertDatabaseHas(RepairJob::class, [
            'id' => $job->id,
            'status' => RepairJobStatusEnum::COMPLETED,
        ]);
    }
}
