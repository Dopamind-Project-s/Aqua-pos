<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Order matters for foreign keys and realistic content relations.
        $this->call([
            AdminUserSeeder::class,
            SiteSettingSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PartnerSeeder::class,
            ClientsSeeder::class,
            PostSeeder::class,
            ServiceRequestSeeder::class,
        ]);
    }
}
