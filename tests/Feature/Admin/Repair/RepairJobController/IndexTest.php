<?php

namespace Tests\Feature\Admin\Repair\RepairJobController;

use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $this->seed();

        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $repair = Repair::first();

        $response = $this->actingAs($admin)->getJson(route('admin.repair.repair-job.index', [
            'id' => $repair->id,
        ]));

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         'jobs' => [
                             ['id', 'status', 'service' => ['id', 'name']]
                         ]
                     ]
                 ]);
    }
}
