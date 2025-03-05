<?php

namespace Tests\Feature\Admin\Repair\RepairController;

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

        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $repair = Repair::first();

        $response = $this->actingAs($admin)->getJson(route('admin.repair.show', $repair->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'repair'
                ],
            ]);
    }
}
