<?php

namespace Tests\Feature\Admin\User\UserController;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_destroy(): void
    {
        $admin = User::factory()->create([
            'role' => RoleEnum::ADMIN,
        ]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->deleteJson(route('admin.user.destroy', [
            'id' => $user->id,
        ]));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing(User::class, [
            'id' => $user->id
        ]);
    }

    public function test_destroy_fails_for_nonexistent_user(): void
    {
        $admin = User::factory()->create([
            'role' => RoleEnum::ADMIN,
        ]);

        $response = $this->actingAs($admin)->deleteJson(route('admin.user.destroy', ['id' => 999]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
