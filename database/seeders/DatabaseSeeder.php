<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure test user exists or update it
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password123'), // add password so login works
                'role' => 'user',
            ]
        );

        // Ensure admin user exists or update it
        User::updateOrCreate(
            ['email' => 'jab0rdzski@gmail.com'],
            [
                'name' => 'Admin00',
                'password' => Hash::make('12345678'), // change to secure password
                'role' => 'admin',
                'is_admin' => true,
            ]
        );
    }
}

