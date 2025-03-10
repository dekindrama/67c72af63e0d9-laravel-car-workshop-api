<?php

namespace Tests\Feature\Admin\Repair\RepairController;

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

        $admin = User::where('role', RoleEnum::ADMIN)->first();

        $response = $this->actingAs($admin)->getJson(route('admin.repair.index'));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'repairs'
                ],
            ]);
    }

    public function test_get_index_wrong_role()
    {
        $this->seed(UserSeeder::class);

        $mechanic = User::where('role', RoleEnum::MECHANIC)->first();

        $response = $this->actingAs($mechanic)->getJson(route('admin.repair.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
