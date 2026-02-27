<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'site_name' => 'AQUA POS',
                'meta_title' => 'AQUA POS | POS & Inventory Software in Jordan',
                'meta_description' => 'AQUA POS is a Jordanian SaaS company in Amman delivering reliable POS and inventory software that helps businesses operate with speed and accuracy.',
                'meta_keywords' => 'AQUA POS, POS Jordan, Inventory Software, Retail POS, Restaurant POS',

                'facebook_url' => 'https://www.facebook.com/aqua.software.co/',
                'instagram_url' => 'https://www.instagram.com/aqua_software/',
                'linkedin_url' => 'https://www.linkedin.com/company/aqua-software/',
                'twitter_url' => null,
                'youtube_url' => null,
                'tiktok_url' => null,

                'whatsapp_number' => '+962791888655',
                'google_map_embed' => 'https://maps.google.com/?q=Amman+Jordan',

                'hq_title' => 'Head Quarter',
                'hq_address' => 'AQUA POS Amman, Jordan',
                'info_email' => 'info@aqua-pos.com',
                'support_email' => 'support@aqua-pos.com',
                'phone_primary' => '+962 79 1888655',
                'phone_secondary' => '+962-791888655',

                'footer_company_title' => 'AQUA POS',
                'footer_company_description' => 'AQUA POS is a Jordanian SaaS company in Amman delivering reliable POS and inventory software that helps businesses operate with speed and accuracy',

                // Legacy KV compatibility columns
                'key' => 'global',
                'value' => null,
                'type' => 'json',
                'group' => 'global',
                'is_public' => true,
            ]
        );
    }
}
