<?php

namespace Tests\Feature\Auth\AuthController;

use App\Helpers\APIHelper;
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

        $response = $this->post(route('auth.login'), [
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
        $response = $this->post(route('auth.login'), [], APIHelper::getHeaders());

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
