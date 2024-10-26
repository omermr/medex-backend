<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@medex.net',
            'password' => Hash::make('P@ssw0rd'),
            'role' => User::ADMIN,
            'status' => User::ACTIVE,
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
