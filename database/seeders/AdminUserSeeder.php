<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@aquapos.com'],
            [
                'name' => 'Super Admin',
                'phone' => '+966500000000',
                'password' => Hash::make('Admin@123456'),
                'avatar' => 'img/defaults/placeholder.svg',
                'status' => true,
                'is_admin' => true,
                'last_login_at' => now(),
                'email_verified_at' => now(),
            ]
        );
    }
}
