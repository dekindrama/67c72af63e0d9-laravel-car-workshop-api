<?php

namespace Tests\Feature\Admin\User\UserController;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_creates_user(): void
    {
        $admin = User::factory()->create([
            'role' => RoleEnum::ADMIN,
        ]);
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'role' => RoleEnum::CAR_OWNER,
        ];

        $response = $this->actingAs($admin)->postJson(route('user.store'), $userData);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email', 'role']
                ]
            ]);
        $this->assertDatabaseHas(User::class, [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'role' => RoleEnum::CAR_OWNER,
        ]);
    }
}
