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
                    'use_cases' => 'Best for supermarkets, mini markets, electronics stores, and boutique retail chains.',
                    'use_cases_en' => 'Best for supermarkets, mini markets, electronics stores, and boutique retail chains.',
                    'use_cases_ar' => 'مناسب للسوبرماركت والميني ماركت ومحلات الإلكترونيات وسلاسل التجزئة.',
                    'price' => 1999.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
                    'is_featured' => true,
                    'is_active' => true,
                ],
            ],
            [
                'category_slug' => 'retail-pos',
                'product' => [
                    'slug' => 'aqua-loyalty-plus',
                    'name' => 'Aqua Loyalty Plus',
                    'name_en' => 'Aqua Loyalty Plus',
                    'name_ar' => 'أكوا ولاء بلس',
                    'tagline' => 'Loyalty and CRM growth engine for retail brands.',
                    'tagline_en' => 'Loyalty and CRM growth engine for retail brands.',
                    'tagline_ar' => 'محرك نمو الولاء وCRM لعلامات التجزئة.',
                    'short_description' => 'Customer loyalty and campaign automation.',
                    'short_description_en' => 'Customer loyalty and campaign automation.',
                    'short_description_ar' => 'إدارة الولاء وحملات التسويق الآلي.',
                    'description' => 'Segment customers, launch rewards, and run personalized retention campaigns.',
                    'description_en' => 'Segment customers, launch rewards, and run personalized retention campaigns.',
                    'description_ar' => 'تقسيم العملاء وإطلاق المكافآت وتشغيل حملات احتفاظ مخصصة.',
                    'key_features' => ['Points Engine', 'Tier Rules', 'Automated Campaigns', 'Customer Segments'],
                    'use_cases' => 'Perfect for chains focused on repeat purchases and customer lifecycle value.',
                    'use_cases_en' => 'Perfect for chains focused on repeat purchases and customer lifecycle value.',
                    'use_cases_ar' => 'مثالي للمتاجر التي تستهدف تكرار الشراء وزيادة قيمة العميل.',
                    'price' => 899.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 2,
                    'is_featured' => false,
                    'is_active' => true,
                ],
            ],
            [
                'category_slug' => 'restaurant-pos',
                'product' => [
                    'slug' => 'aqua-food-suite',
                    'name' => 'Aqua Food Suite',
                    'name_en' => 'Aqua Food Suite',
                    'name_ar' => 'أكوا فود سويت',
                    'tagline' => 'Restaurant POS built for speed and control.',
                    'tagline_en' => 'Restaurant POS built for speed and control.',
                    'tagline_ar' => 'نظام مطاعم مصمم للسرعة والتحكم.',
                    'short_description' => 'POS for restaurants and kitchens.',
                    'short_description_en' => 'POS for restaurants and kitchens.',
                    'short_description_ar' => 'إدارة الطلبات والصالات والمطبخ في منصة واحدة.',
                    'description' => 'Table management, kitchen screens, and delivery integrations.',
                    'description_en' => 'Table management, kitchen screens, and delivery integrations.',
                    'description_ar' => 'إدارة الطاولات وشاشات المطبخ وتكاملات التوصيل.',
                    'key_features' => ['Table Mapping', 'Kitchen Display', 'Delivery Integration', 'Live Sales Insights'],
                    'use_cases' => 'Ideal for dine-in restaurants, cafes, fast casual, and delivery-first kitchens.',
                    'use_cases_en' => 'Ideal for dine-in restaurants, cafes, fast casual, and delivery-first kitchens.',
                    'use_cases_ar' => 'مثالي للمطاعم والكافيهات ومطابخ التوصيل.',
                    'price' => 2499.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
                    'is_featured' => true,
                    'is_active' => true,
                ],
            ],
            [
                'category_slug' => 'restaurant-pos',
                'product' => [
                    'slug' => 'aqua-qr-ordering',
                    'name' => 'Aqua QR Ordering',
                    'name_en' => 'Aqua QR Ordering',
                    'name_ar' => 'أكوا طلب عبر QR',
                    'tagline' => 'Contactless ordering and payment experience.',
                    'tagline_en' => 'Contactless ordering and payment experience.',
                    'tagline_ar' => 'تجربة طلب ودفع بدون تلامس.',
                    'short_description' => 'Digital menu ordering via QR with integrated payment.',
                    'short_description_en' => 'Digital menu ordering via QR with integrated payment.',
                    'short_description_ar' => 'طلب رقمي عبر QR مع تكامل الدفع.',
                    'description' => 'Let guests order and pay from phones while syncing orders directly to POS and kitchen.',
                    'description_en' => 'Let guests order and pay from phones while syncing orders directly to POS and kitchen.',
                    'description_ar' => 'يسمح للعميل بالطلب والدفع من الهاتف مع مزامنة مباشرة لنقطة البيع والمطبخ.',
                    'key_features' => ['QR Menu', 'Mobile Payment', 'Order Sync', 'Upsell Prompts'],
                    'use_cases' => 'Great for high-traffic cafes, food courts, and table-service venues.',
                    'use_cases_en' => 'Great for high-traffic cafes, food courts, and table-service venues.',
                    'use_cases_ar' => 'مناسب للكافيهات المزدحمة ومجمعات الطعام والمطاعم بخدمة الطاولة.',
                    'price' => 699.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 2,
                    'is_featured' => false,
                    'is_active' => true,
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
                    'key_features' => ['ERP API Sync', 'Accounting Journals', 'Multi-branch Consolidation', 'Audit Logs'],
                    'use_cases' => 'Designed for organizations needing enterprise reporting and financial traceability.',
                    'use_cases_en' => 'Designed for organizations needing enterprise reporting and financial traceability.',
                    'use_cases_ar' => 'مناسب للشركات التي تحتاج تقارير مؤسسية وتتبع مالي.',
                    'price' => 1499.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
                    'is_featured' => true,
                    'is_active' => true,
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
                    'key_features' => ['Front Desk Flows', 'Guest Billing', 'Outlet Reporting', 'Multi-outlet Sync'],
                    'use_cases' => 'Suitable for hotels, resorts, and serviced apartment chains.',
                    'use_cases_en' => 'Suitable for hotels, resorts, and serviced apartment chains.',
                    'use_cases_ar' => 'مناسب للفنادق والمنتجعات والشقق الفندقية.',
                    'price' => 1799.00,
                    'price_note' => 'Starting from',
                    'sort_order' => 1,
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
                    'alt' => $product->name_en ?: $product->name,
                ]
            );
        }
    }
}
