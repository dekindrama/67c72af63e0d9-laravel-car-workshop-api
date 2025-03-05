<?php

namespace Tests\Feature\CarOwner\Reoair\RepairController;

use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_show()
    {
        $this->seed();

        $carOwner = User::where('role', RoleEnum::CAR_OWNER)->first();
        $repair = Repair::first();

        $response = $this->actingAs($carOwner)->getJson(route('car-owner.repair.show', $repair->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'repair'
                ],
            ]);
    }
}
