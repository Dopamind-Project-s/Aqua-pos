<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SiteSettingSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PostSeeder::class,
            PartnerSeeder::class,
            ClientsSeeder::class,
            ServiceRequestSeeder::class,
        ]);
    }
}
