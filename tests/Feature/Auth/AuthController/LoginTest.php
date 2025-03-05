<?php

namespace Tests\Feature\Auth\AuthController;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_login(): void
    {
        $this->seed(UserSeeder::class);

        $response = $this->postJson(route('auth.login'), [
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'token',
                ],
            ]);
    }

    public function test_login_bad_request(): void
    {
        $response = $this->postJson(route('auth.login'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
