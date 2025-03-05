<?php

namespace Tests\Feature\Auth\AuthController;

use App\Enums\RoleEnum;
use App\Helpers\APIHelper;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoggedUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_get_logged_user() {
        $this->seed(UserSeeder::class);

        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $response = $this->actingAs($admin)->get(route('auth.logged-user'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'user',
                ],
            ]);
    }

    function test_get_logged_user_unauthenticated() {
        $response = $this->get(route('auth.logged-user'), APIHelper::getHeaders());

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
