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
                    'name' => 'Aqua Retail Pro',
                    'name_ar' => 'أكوا ريتيل برو',
                    'name_en' => 'Aqua Retail Pro',
                    'tagline' => 'All-in-one POS for modern retailers.',
                    'tagline_ar' => 'نظام نقطة بيع متكامل لمتاجر التجزئة الحديثة.',
                    'tagline_en' => 'All-in-one POS for modern retailers.',
                    'slug' => 'aqua-retail-pro',
                    'short_description' => 'Complete POS for retail stores.',
                    'short_description_ar' => 'نظام متكامل لمتاجر التجزئة.',
                    'short_description_en' => 'Complete POS for retail stores.',
                    'description' => 'Inventory, barcode, invoices, and sales analytics in one system.',
                    'description_ar' => 'إدارة المخزون والباركود والفواتير وتحليلات المبيعات في نظام واحد.',
                    'description_en' => 'Inventory, barcode, invoices, and sales analytics in one system.',
                    'key_features' => ['Barcode Sales', 'Inventory Sync', 'Customer Loyalty', 'Branch Dashboard'],
                    'use_cases' => 'Best for supermarkets, mini markets, electronics stores, and boutique retail chains.',
                    'use_cases_ar' => 'مناسب للسوبرماركت والميني ماركت ومحلات الإلكترونيات وسلاسل التجزئة.',
                    'use_cases_en' => 'Best for supermarkets, mini markets, electronics stores, and boutique retail chains.',
                    'price' => 1999.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
                    'is_featured' => true,
                    'is_active' => true,
                ],
            ],
            [
                'category_slug' => 'restaurant-pos',
                'product' => [
                    'name' => 'Aqua Food Suite',
                    'name_ar' => 'أكوا فود سويت',
                    'name_en' => 'Aqua Food Suite',
                    'tagline' => 'Restaurant POS built for speed and control.',
                    'tagline_ar' => 'نظام مطاعم مصمم للسرعة والتحكم.',
                    'tagline_en' => 'Restaurant POS built for speed and control.',
                    'slug' => 'aqua-food-suite',
                    'short_description' => 'POS for restaurants and kitchens.',
                    'short_description_ar' => 'نظام للمطاعم والمطابخ.',
                    'short_description_en' => 'POS for restaurants and kitchens.',
                    'description' => 'Table management, kitchen screens, and delivery integrations.',
                    'description_ar' => 'إدارة الطاولات وشاشات المطبخ وتكاملات التوصيل.',
                    'description_en' => 'Table management, kitchen screens, and delivery integrations.',
                    'key_features' => ['Table Mapping', 'Kitchen Display', 'Delivery Integration', 'Live Sales Insights'],
                    'use_cases' => 'Ideal for dine-in restaurants, cafes, fast casual, and delivery-first kitchens.',
                    'use_cases_ar' => 'مثالي للمطاعم والكافيهات ومطابخ التوصيل.',
                    'use_cases_en' => 'Ideal for dine-in restaurants, cafes, fast casual, and delivery-first kitchens.',
                    'price' => 2499.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 2,
                    'is_featured' => true,
                    'is_active' => true,
                ],
            ],
            [
                'category_slug' => 'erp-integrations',
                'product' => [
                    'name' => 'Aqua Integrator',
                    'name_ar' => 'أكوا إنتيجريتور',
                    'name_en' => 'Aqua Integrator',
                    'tagline' => 'Reliable integrations with your financial stack.',
                    'tagline_ar' => 'تكاملات موثوقة مع أنظمتك المالية.',
                    'tagline_en' => 'Reliable integrations with your financial stack.',
                    'slug' => 'aqua-integrator',
                    'short_description' => 'ERP and accounting integration module.',
                    'short_description_ar' => 'وحدة تكامل مع ERP والمحاسبة.',
                    'short_description_en' => 'ERP and accounting integration module.',
                    'description' => 'Connect POS data to ERP, accounting, and BI tools securely.',
                    'description_ar' => 'ربط بيانات نقاط البيع مع ERP والمحاسبة وأدوات ذكاء الأعمال بأمان.',
                    'description_en' => 'Connect POS data to ERP, accounting, and BI tools securely.',
                    'key_features' => ['ERP API Sync', 'Accounting Journals', 'Multi-branch Consolidation', 'Audit Logs'],
                    'use_cases' => 'Designed for organizations needing enterprise reporting and financial traceability.',
                    'use_cases_ar' => 'مناسب للشركات التي تحتاج تقارير مؤسسية وتتبع مالي.',
                    'use_cases_en' => 'Designed for organizations needing enterprise reporting and financial traceability.',
                    'price' => 1499.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 3,
                    'is_featured' => false,
                    'is_active' => true,
                ],
            ],
        ];

        foreach ($rows as $row) {
            $category = Category::where('slug', $row['category_slug'])->first();
            if (! $category) {
                continue;
            }

            $product = Product::updateOrCreate(
                ['slug' => $row['product']['slug']],
                array_merge($row['product'], ['category_id' => $category->id])
            );

            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'sort_order' => 1],
                [
                    'image' => 'img/defaults/placeholder.svg',
                    'alt' => $product->name,
                ]
            );
        }
    }
}
