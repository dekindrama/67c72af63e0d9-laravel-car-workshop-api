<?php

namespace Tests\Feature\Admin\ServiceController;

use App\Enums\RoleEnum;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    function test_get_services() {
        $this->seed(UserSeeder::class);

        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $services = Service::factory(5)->create();

        $response = $this->actingAs($admin)->get(route('service.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'services',
            ],
        ]);
        $response->assertJsonCount(5, 'data.services');
    }

    function test_get_services_wrong_user_role() {
        $this->seed(UserSeeder::class);

        $mechanic = User::where('role', RoleEnum::MECHANIC)->first();

        $response = $this->actingAs($mechanic)->get(route('service.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
