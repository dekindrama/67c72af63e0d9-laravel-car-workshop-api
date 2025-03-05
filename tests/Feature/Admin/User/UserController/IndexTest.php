<?php

namespace Tests\Feature\Admin\User\UserController;

use App\Enums\RoleEnum;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_index(): void
    {
        $admin = User::factory()->create([
            'role' => RoleEnum::ADMIN,
        ]);

        $response = $this->actingAs($admin)->getJson(route('user.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'users' => [
                        '*' => ['id', 'name', 'email', 'role']
                    ]
                ]
            ])
            ->assertJsonCount(1, 'data.users');
    }

    function test_get_services_wrong_user_role() {
        $mechanic = User::factory()->create([
            'role' => RoleEnum::MECHANIC,
        ]);

        $response = $this->actingAs($mechanic)->getJson(route('user.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
