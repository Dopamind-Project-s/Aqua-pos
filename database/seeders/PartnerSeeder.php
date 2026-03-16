<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'PayGate',
                'name_en' => 'PayGate',
                'name_ar' => 'باي جيت',
                'slug' => 'paygate',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Certified payment gateway integration partner.',
                'description_en' => 'Certified payment gateway integration partner.',
                'description_ar' => 'شريك معتمد لتكامل بوابات الدفع الإلكتروني.',
                'website_url' => 'https://example.com/paygate',
                'apply_url' => 'https://example.com/paygate/apply',
                'facebook_url' => 'https://facebook.com/paygate',
                'instagram_url' => 'https://instagram.com/paygate',
                'linkedin_url' => 'https://linkedin.com/company/paygate',
                'twitter_url' => 'https://x.com/paygate',
                'youtube_url' => 'https://youtube.com/@paygate',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'CloudBooks',
                'name_en' => 'CloudBooks',
                'name_ar' => 'كلاود بوكس',
                'slug' => 'cloudbooks',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Accounting and finance integration partner.',
                'description_en' => 'Accounting and finance integration partner.',
                'description_ar' => 'شريك تكاملات المحاسبة والأنظمة المالية.',
                'website_url' => 'https://example.com/cloudbooks',
                'apply_url' => 'https://example.com/cloudbooks/partner',
                'linkedin_url' => 'https://linkedin.com/company/cloudbooks',
                'twitter_url' => 'https://x.com/cloudbooks',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'LogistiPro',
                'name_en' => 'LogistiPro',
                'name_ar' => 'لوجيستي برو',
                'slug' => 'logistipro',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Fulfillment and shipping automation partner.',
                'description_en' => 'Fulfillment and shipping automation partner.',
                'description_ar' => 'شريك أتمتة الشحن وإدارة الطلبات.',
                'website_url' => 'https://example.com/logistipro',
                'linkedin_url' => 'https://linkedin.com/company/logistipro',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::query()->updateOrCreate(['slug' => $partner['slug']], $partner);
        }
    }
}
