<?php

namespace Tests\Feature\Admin\Service\ServiceController;

use App\Enums\RoleEnum;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_show(): void
    {
        $this->seed();
        $admin = User::where('role', RoleEnum::ADMIN)->first();
        $service = Service::first();

        $response = $this->actingAs($admin)->get(route('admin.service.show', $service->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'service' => ['id', 'name', 'price'],
                ],
            ]);
    }
}
