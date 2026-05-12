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
                'primary_logo' => null,
                'secondary_logo' => null,
                'meta_title' => 'AQUA POS | Cloud POS, Inventory & ERP Integrations',
                'meta_description' => 'AQUA POS helps restaurants and retailers run billing, inventory, multi-branch operations, and analytics from one cloud platform.',
                'meta_keywords' => 'AQUA POS, POS Jordan, Inventory Software, Retail POS, Restaurant POS, Cloud POS, ERP Integration',

                'facebook_url' => 'https://www.facebook.com/aqua.software.co/',
                'instagram_url' => 'https://www.instagram.com/aqua_software/',
                'linkedin_url' => 'https://www.linkedin.com/company/aqua-software/',
                'twitter_url' => 'https://x.com/aqua_pos',
                'youtube_url' => 'https://www.youtube.com/@aquapos',
                'tiktok_url' => 'https://www.tiktok.com/@aquapos',

                'whatsapp_number' => '+962791888655',
                'google_map_embed' => 'https://maps.google.com/?q=Aqua+POS+Amman+Jordan',

                'hq_title' => 'Head Office',
                'hq_address' => 'AQUA POS, Amman, Jordan',
                'info_email' => 'info@aqua-pos.com',
                'support_email' => 'support@aqua-pos.com',
                'phone_primary' => '+962 79 1888655',
                'phone_secondary' => '+962 6 5920000',

                'footer_company_title' => 'AQUA POS',
                'footer_company_description' => 'AQUA POS delivers cloud POS, inventory, and business automation tools that improve speed, control, and growth for modern businesses.',
                'about_site_paragraph' => 'AQUA POS is a unified cloud platform that connects sales, inventory, analytics, and customer operations to help businesses scale with confidence.',
                'home_solution_video' => null,

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
