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
                    'slug' => 'aqua-retail-pro',
                    'short_description' => 'Complete POS for retail stores.',
                    'description' => 'Inventory, barcode, invoices, and sales analytics in one system.',
                    'price' => 1999.00,
                    'price_note' => 'Starting from',
                    'is_featured' => true,
                    'is_active' => true,
                ],
            ],
            [
                'category_slug' => 'restaurant-pos',
                'product' => [
                    'name' => 'Aqua Food Suite',
                    'slug' => 'aqua-food-suite',
                    'short_description' => 'POS for restaurants and kitchens.',
                    'description' => 'Table management, kitchen screens, and delivery integrations.',
                    'price' => 2499.00,
                    'price_note' => 'Starting from',
                    'is_featured' => true,
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
