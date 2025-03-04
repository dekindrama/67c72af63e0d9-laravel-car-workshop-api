<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'user admin',
            'email' => 'admin@example.com',
            'role' => RoleEnum::ADMIN,
        ]);

        $mechanic = User::factory()->create([
            'name' => 'user mechanic',
            'email' => 'mechanic@example.com',
            'role' => RoleEnum::MECHANIC,
        ]);

        $owner = User::factory()->create([
            'name' => 'user owner',
            'email' => 'owner@example.com',
            'role' => RoleEnum::CAR_OWNER,
        ]);
    }
}
