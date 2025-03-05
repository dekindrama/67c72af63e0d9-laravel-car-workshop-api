<?php

namespace Tests\Feature\Mechanic\Job\JobController;

use App\Enums\RoleEnum;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_index()
    {
        $this->seed();

        $mechanic = User::where('role', RoleEnum::MECHANIC)->first();

        $response = $this->actingAs($mechanic)->getJson(route('mechanic.job.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'jobs'
                ],
            ]);
    }

    public function test_get_index_wrong_role()
    {
        $this->seed(UserSeeder::class);

        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $response = $this->actingAs($admin)->getJson(route('mechanic.job.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
