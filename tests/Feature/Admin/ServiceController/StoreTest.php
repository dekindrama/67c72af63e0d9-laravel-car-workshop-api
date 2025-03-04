<?php

namespace Tests\Feature\Admin\ServiceController;

use App\Enums\RoleEnum;
use App\Helpers\APIHelper;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_store(): void
    {
        $this->seed(UserSeeder::class);
        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $request = [
            'name' => 'service 1',
            'price' => 120,
        ];

        $response = $this->actingAs($admin)->post(route('service.store'), $request);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'service',
            ],
        ]);
    }

    public function test_store_bad_request(): void
    {
        $this->seed(UserSeeder::class);
        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $request = [];

        $response = $this->actingAs($admin)->post(route('service.store'), $request, APIHelper::getHeaders());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

    }
}
