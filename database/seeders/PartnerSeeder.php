<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'name' => 'PayGate',
                'slug' => 'paygate',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Payment gateway integration partner.',
                'website_url' => 'https://example.com/paygate',
                'apply_url' => 'https://example.com/paygate/apply',
                'facebook_url' => 'https://facebook.com',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'CloudBooks',
                'slug' => 'cloudbooks',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Accounting integration partner.',
                'website_url' => 'https://example.com/cloudbooks',
                'linkedin_url' => 'https://linkedin.com',
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($rows as $row) {
            Partner::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
