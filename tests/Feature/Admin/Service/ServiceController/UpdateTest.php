<?php

namespace Tests\Feature\Admin\Service\ServiceController;

use App\Enums\RoleEnum;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_update(): void
    {
        $this->seed(UserSeeder::class);
        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $service = Service::factory()->create();

        $request = [
            'name' => 'service 1',
            'price' => 120,
        ];

        $response = $this->actingAs($admin)->putJson(route('service.update', ['id' => $service->id]), $request);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'service',
                ],
            ]);
        $this->assertDatabaseHas(Service::class, $request);
    }

    public function test_update_service_not_found(): void
    {
        $this->seed(UserSeeder::class);
        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $request = [
            'name' => 'service 1',
            'price' => 120,
        ];

        $response = $this->actingAs($admin)->putJson(route('service.update', ['id' => 999]), $request);

        $response->assertStatus(Response::HTTP_NOT_FOUND);

    }

    public function test_update_bad_request(): void
    {
        $this->seed(UserSeeder::class);
        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $request = [];

        $response = $this->actingAs($admin)->putJson(route('service.update', ['id' => fake()->uuid()]), $request);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }
}
