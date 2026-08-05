<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@inventory.com'],
            [
                'name' => 'Administrator Inventory',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@inventory.com'],
            [
                'name' => 'Staff Inventory',
                'password' => Hash::make('password'),
                'role' => UserRole::USER,
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
