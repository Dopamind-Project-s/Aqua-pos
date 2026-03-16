<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => env('SEED_ADMIN_EMAIL', 'admin@aquapos.com'),
                'name' => 'Super Admin',
                'phone' => '+962791888655',
                'password' => Hash::make(env('SEED_ADMIN_PASSWORD', 'Admin@123456')),
                'avatar' => 'img/defaults/placeholder.svg',
                'status' => true,
                'is_admin' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
            ],
            [
                'email' => 'content.manager@aquapos.com',
                'name' => 'Content Manager',
                'phone' => '+962790000111',
                'password' => Hash::make('Manager@123456'),
                'avatar' => 'img/defaults/placeholder.svg',
                'status' => true,
                'is_admin' => true,
                'email_verified_at' => now(),
                'last_login_at' => now()->subDay(),
            ],
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
