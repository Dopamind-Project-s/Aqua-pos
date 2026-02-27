<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'slug' => 'retail-pos',
                'name' => 'Retail POS',
                'name_en' => 'Retail POS',
                'name_ar' => 'نقاط بيع التجزئة',
                'description' => 'POS and backoffice operations for retail stores.',
                'description_en' => 'POS and backoffice operations for retail stores.',
                'description_ar' => 'نظام نقاط البيع وتشغيل العمليات الخلفية لمتاجر التجزئة.',
                'image' => 'img/defaults/placeholder.svg',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'restaurant-pos',
                'name' => 'Restaurant POS',
                'name_en' => 'Restaurant POS',
                'name_ar' => 'نقاط بيع المطاعم',
                'description' => 'End-to-end restaurant operations and kitchen workflows.',
                'description_en' => 'End-to-end restaurant operations and kitchen workflows.',
                'description_ar' => 'إدارة تشغيل المطاعم من الطلب وحتى المطبخ والتقارير.',
                'image' => 'img/defaults/placeholder.svg',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'erp-integrations',
                'name' => 'ERP Integrations',
                'name_en' => 'ERP Integrations',
                'name_ar' => 'تكاملات ERP',
                'description' => 'Financial and ERP integration stack for enterprise visibility.',
                'description_en' => 'Financial and ERP integration stack for enterprise visibility.',
                'description_ar' => 'تكاملات مالية ومؤسسية مع ERP لرفع مستوى الرؤية والتحكم.',
                'image' => 'img/defaults/placeholder.svg',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'slug' => 'hospitality',
                'name' => 'Hospitality',
                'name_en' => 'Hospitality',
                'name_ar' => 'الضيافة',
                'description' => 'Hospitality-focused solutions for hotels and resorts.',
                'description_en' => 'Hospitality-focused solutions for hotels and resorts.',
                'description_ar' => 'حلول متخصصة لقطاع الضيافة والفنادق والمنتجعات.',
                'image' => 'img/defaults/placeholder.svg',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($rows as $row) {
            Category::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
