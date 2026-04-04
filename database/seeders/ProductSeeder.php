<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'category_slug' => 'retail-pos',
                'product' => [
                    'slug' => 'aqua-retail-pro',
                    'name' => 'Aqua Retail Pro',
                    'name_en' => 'Aqua Retail Pro',
                    'name_ar' => 'أكوا ريتيل برو',
                    'tagline' => 'All-in-one POS for modern retailers.',
                    'tagline_en' => 'All-in-one POS for modern retailers.',
                    'tagline_ar' => 'نظام نقاط بيع شامل لمتاجر التجزئة الحديثة.',
                    'short_description' => 'Complete POS for retail stores.',
                    'short_description_en' => 'Complete POS for retail stores.',
                    'short_description_ar' => 'حل متكامل لإدارة البيع والمخزون بالتجزئة.',
                    'description' => 'Inventory, barcode, invoices, and sales analytics in one system.',
                    'description_en' => 'Inventory, barcode, invoices, and sales analytics in one system.',
                    'description_ar' => 'إدارة المخزون والباركود والفواتير وتحليلات المبيعات في نظام واحد.',
                    'key_features' => ['Barcode Sales', 'Inventory Sync', 'Customer Loyalty', 'Branch Dashboard'],
                    'use_cases' => 'Best for supermarkets, electronics stores, and retail chains.',
                    'use_cases_en' => 'Best for supermarkets, electronics stores, and retail chains.',
                    'use_cases_ar' => 'مناسب للسوبرماركت ومحلات الإلكترونيات وسلاسل التجزئة.',
                    'image' => 'img/defaults/placeholder.svg',
                    'price' => 1999.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
                    'is_featured' => true,
                    'is_active' => true,
                ],
                'images' => [
                    ['image' => 'img/defaults/placeholder.svg', 'alt' => 'Retail dashboard overview'],
                    ['image' => 'img/defaults/placeholder.svg', 'alt' => 'Retail checkout interface'],
                    ['image' => 'img/defaults/placeholder.svg', 'alt' => 'Retail inventory screen'],
                ],
            ],
            [
                'category_slug' => 'restaurant-pos',
                'product' => [
                    'slug' => 'aqua-restaurant-pro',
                    'name' => 'Aqua Restaurant Pro',
                    'name_en' => 'Aqua Restaurant Pro',
                    'name_ar' => 'أكوا ريستورانت برو',
                    'tagline' => 'Fast ordering and kitchen orchestration for restaurants.',
                    'tagline_en' => 'Fast ordering and kitchen orchestration for restaurants.',
                    'tagline_ar' => 'طلب سريع وإدارة ذكية لسير عمل المطبخ.',
                    'short_description' => 'Restaurant POS with KDS and table management.',
                    'short_description_en' => 'Restaurant POS with KDS and table management.',
                    'short_description_ar' => 'نظام مطاعم مع شاشة مطبخ وإدارة الطاولات.',
                    'description' => 'Speed up service by connecting cashier, waiters, and kitchen in one flow.',
                    'description_en' => 'Speed up service by connecting cashier, waiters, and kitchen in one flow.',
                    'description_ar' => 'تسريع الخدمة عبر ربط الكاشير والنادل والمطبخ في تدفق موحد.',
                    'key_features' => ['Table Mapping', 'Kitchen Display', 'Modifier Rules', 'Delivery Integrations'],
                    'use_cases' => 'Designed for dine-in restaurants, cafes, and dark kitchens.',
                    'use_cases_en' => 'Designed for dine-in restaurants, cafes, and dark kitchens.',
                    'use_cases_ar' => 'مناسب للمطاعم والكافيهات والمطابخ السحابية.',
                    'image' => 'img/defaults/placeholder.svg',
                    'price' => 1699.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
                    'is_featured' => true,
                    'is_active' => true,
                ],
                'images' => [
                    ['image' => 'img/defaults/placeholder.svg', 'alt' => 'Restaurant floor map'],
                    ['image' => 'img/defaults/placeholder.svg', 'alt' => 'Kitchen display management'],
                ],
            ],
            [
                'category_slug' => 'erp-integrations',
                'product' => [
                    'slug' => 'aqua-integrator',
                    'name' => 'Aqua Integrator',
                    'name_en' => 'Aqua Integrator',
                    'name_ar' => 'أكوا إنتيجريتور',
                    'tagline' => 'Reliable integrations with your financial stack.',
                    'tagline_en' => 'Reliable integrations with your financial stack.',
                    'tagline_ar' => 'تكاملات موثوقة مع أنظمتك المالية.',
                    'short_description' => 'ERP and accounting integration module.',
                    'short_description_en' => 'ERP and accounting integration module.',
                    'short_description_ar' => 'وحدة تكامل مع ERP والمحاسبة.',
                    'description' => 'Connect POS data to ERP, accounting, and BI tools securely.',
                    'description_en' => 'Connect POS data to ERP, accounting, and BI tools securely.',
                    'description_ar' => 'ربط بيانات نقاط البيع مع ERP والمحاسبة وأدوات ذكاء الأعمال بأمان.',
                    'key_features' => ['ERP API Sync', 'Accounting Journals', 'Consolidated Reporting', 'Audit Logs'],
                    'use_cases' => 'Ideal for organizations requiring enterprise reporting and compliance.',
                    'use_cases_en' => 'Ideal for organizations requiring enterprise reporting and compliance.',
                    'use_cases_ar' => 'مناسب للشركات التي تحتاج تقارير مؤسسية وحوكمة دقيقة.',
                    'image' => 'img/defaults/placeholder.svg',
                    'price' => 1499.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
                    'is_featured' => true,
                    'is_active' => true,
                ],
                'images' => [
                    ['image' => 'img/defaults/placeholder.svg', 'alt' => 'Integration connectors'],
                ],
            ],
            [
                'category_slug' => 'hospitality',
                'product' => [
                    'slug' => 'aqua-hospitality-desk',
                    'name' => 'Aqua Hospitality Desk',
                    'name_en' => 'Aqua Hospitality Desk',
                    'name_ar' => 'أكوا هوسبيتاليتي ديسك',
                    'tagline' => 'Unified operations for hospitality and guest services.',
                    'tagline_en' => 'Unified operations for hospitality and guest services.',
                    'tagline_ar' => 'إدارة موحدة لعمليات الضيافة وخدمات النزلاء.',
                    'short_description' => 'Hospitality operations and service management module.',
                    'short_description_en' => 'Hospitality operations and service management module.',
                    'short_description_ar' => 'وحدة إدارة تشغيل وخدمات قطاع الضيافة.',
                    'description' => 'Coordinate front desk workflows, in-house billing, and outlet consumption reporting.',
                    'description_en' => 'Coordinate front desk workflows, in-house billing, and outlet consumption reporting.',
                    'description_ar' => 'تنسيق سير عمل الاستقبال والفوترة الداخلية وتقارير الاستهلاك.',
                    'key_features' => ['Guest Billing', 'Front Desk Flows', 'Outlet Reporting', 'Shift Controls'],
                    'use_cases' => 'Suitable for hotels, resorts, and serviced apartment chains.',
                    'use_cases_en' => 'Suitable for hotels, resorts, and serviced apartment chains.',
                    'use_cases_ar' => 'مناسب للفنادق والمنتجعات والشقق الفندقية.',
                    'image' => 'img/defaults/placeholder.svg',
                    'price' => 1799.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
                    'is_featured' => false,
                    'is_active' => true,
                ],
                'images' => [
                    ['image' => 'img/defaults/placeholder.svg', 'alt' => 'Hospitality service console'],
                    ['image' => 'img/defaults/placeholder.svg', 'alt' => 'Guest billing overview'],
                ],
            ],
        ];

        foreach ($rows as $row) {
            $category = Category::query()->where('slug', $row['category_slug'])->first();
            if (! $category) {
                continue;
            }

            $product = Product::query()->withTrashed()->updateOrCreate(
                ['slug' => $row['product']['slug']],
                array_merge($row['product'], ['category_id' => $category->id, 'deleted_at' => null])
            );

            foreach ($row['images'] as $index => $image) {
                ProductImage::query()->updateOrCreate(
                    ['product_id' => $product->id, 'sort_order' => $index + 1],
                    [
                        'image' => $image['image'],
                        'alt' => $image['alt'],
                    ]
                );
            }
        }
    }
}
