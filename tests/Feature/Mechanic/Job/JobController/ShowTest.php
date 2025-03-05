<?php

namespace Tests\Feature\Mechanic\Job\JobController;

use App\Enums\RoleEnum;
use App\Models\RepairJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_show()
    {
        $this->seed();

        $mechanic = User::where('role', RoleEnum::MECHANIC)->first();
        $job = RepairJob::first();

        $response = $this->actingAs($mechanic)->getJson(route('mechanic.job.show', $job->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'job'
                ],
            ]);
    }
}
