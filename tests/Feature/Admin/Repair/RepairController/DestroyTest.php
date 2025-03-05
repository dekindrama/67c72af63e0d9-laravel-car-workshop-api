<?php

namespace Tests\Feature\Admin\Repair\RepairController;

use App\Enums\RoleEnum;
use App\Models\Repair;
use App\Models\RepairCar;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_destroy(): void
    {
        $this->seed();
        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $repair = Repair::first();

        $response = $this->actingAs($admin)->deleteJson(route('repair.destroy', ['id' => $repair->id]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
            ]);
        $this->assertDatabaseMissing(Repair::class, [
            'id' => $repair->id,
        ]);
        $this->assertDatabaseMissing(RepairCar::class, [
            'repair_id' => $repair->id,
        ]);
    }
}
