<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Royal Bistro',
                'name_en' => 'Royal Bistro',
                'name_ar' => 'رويال بيسترو',
                'slug' => 'royal-bistro',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Premium dining chain using AQUA POS across multiple cities.',
                'description_en' => 'Premium dining chain using AQUA POS across multiple cities.',
                'description_ar' => 'سلسلة مطاعم مميزة تستخدم AQUA POS في عدة مدن.',
                'website_url' => 'https://example.com/royal-bistro',
                'facebook_url' => 'https://facebook.com/royalbistro',
                'instagram_url' => 'https://instagram.com/royalbistro',
                'linkedin_url' => 'https://linkedin.com/company/royalbistro',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Urban Market',
                'name_en' => 'Urban Market',
                'name_ar' => 'أوربان ماركت',
                'slug' => 'urban-market',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Fast-growing retail chain with integrated inventory workflows.',
                'description_en' => 'Fast-growing retail chain with integrated inventory workflows.',
                'description_ar' => 'سلسلة تجزئة متنامية مع إدارة مخزون متكاملة.',
                'website_url' => 'https://example.com/urban-market',
                'instagram_url' => 'https://instagram.com/urbanmarket',
                'youtube_url' => 'https://youtube.com/@urbanmarket',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Cedar Hotels',
                'name_en' => 'Cedar Hotels',
                'name_ar' => 'سيدر للفنادق',
                'slug' => 'cedar-hotels',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Hospitality group managing hotels and resort outlets.',
                'description_en' => 'Hospitality group managing hotels and resort outlets.',
                'description_ar' => 'مجموعة ضيافة تدير فنادق ومنافذ بيع في المنتجعات.',
                'website_url' => 'https://example.com/cedar-hotels',
                'facebook_url' => 'https://facebook.com/cedarhotels',
                'twitter_url' => 'https://x.com/cedarhotels',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Nexa Pharmacy',
                'name_en' => 'Nexa Pharmacy',
                'name_ar' => 'نيكسا فارمسي',
                'slug' => 'nexa-pharmacy',
                'logo' => 'img/defaults/placeholder.svg',
                'description' => 'Pharmacy chain improving dispensing speed and stock control.',
                'description_en' => 'Pharmacy chain improving dispensing speed and stock control.',
                'description_ar' => 'سلسلة صيدليات لتحسين سرعة البيع ودقة المخزون.',
                'website_url' => 'https://example.com/nexa-pharmacy',
                'linkedin_url' => 'https://linkedin.com/company/nexa-pharmacy',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($clients as $client) {
            Client::query()->updateOrCreate(['slug' => $client['slug']], $client);
        }
    }
}
