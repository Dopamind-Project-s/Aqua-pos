<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Royal Bistro', 'slug' => 'royal-bistro', 'logo' => 'img/defaults/placeholder.svg', 'website_url' => 'https://example.com/royal', 'linkedin_url' => 'https://linkedin.com', 'sort_order' => 1, 'is_active' => true],
            ['name' => 'Urban Market', 'slug' => 'urban-market', 'logo' => 'img/defaults/placeholder.svg', 'website_url' => 'https://example.com/urban', 'instagram_url' => 'https://instagram.com', 'sort_order' => 2, 'is_active' => true],
            ['name' => 'Cedar Hotels', 'slug' => 'cedar-hotels', 'logo' => 'img/defaults/placeholder.svg', 'facebook_url' => 'https://facebook.com', 'twitter_url' => 'https://x.com', 'sort_order' => 3, 'is_active' => true],
        ];

        foreach ($rows as $row) {
            Client::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
