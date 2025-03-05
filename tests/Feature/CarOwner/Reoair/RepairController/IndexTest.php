<?php

namespace Tests\Feature\CarOwner\Reoair\RepairController;

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

        $carOwner = User::where('role', RoleEnum::CAR_OWNER)->first();

        $response = $this->actingAs($carOwner)->getJson(route('car-owner.repair.index'));

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

        $response = $this->actingAs($mechanic)->getJson(route('car-owner.repair.index'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
