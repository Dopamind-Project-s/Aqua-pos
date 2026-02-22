<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['key' => 'contact_phone', 'value' => '+966500000000', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'whatsapp', 'value' => '+966500000000', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'contact_email', 'value' => 'info@aquapos.com', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
            ['key' => 'social_links', 'value' => json_encode([
                'instagram' => 'https://instagram.com/aquapos',
                'facebook' => 'https://facebook.com/aquapos',
                'linkedin' => 'https://linkedin.com/company/aquapos',
            ]), 'type' => 'json', 'group' => 'social', 'is_public' => true],
            ['key' => 'business_hours', 'value' => 'Sun-Thu 09:00-18:00', 'type' => 'string', 'group' => 'contact', 'is_public' => true],
        ];

        foreach ($rows as $row) {
            SiteSetting::updateOrCreate(['key' => $row['key']], $row);
        }
    }
}
