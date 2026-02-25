<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'HR Admin',
                'email' => 'admin@atlastech.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@atlastech.com',
                'password' => Hash::make('password123'),
                'role' => 'hr',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Inactive User',
                'email' => 'inactive@atlastech.com',
                'password' => Hash::make('password123'),
                'role' => 'hr',
                'is_active' => false,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'IT Administrator',
                'email' => 'itadmin@atlastech.com',
                'password' => Hash::make('password123'),
                'role' => 'it_admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
