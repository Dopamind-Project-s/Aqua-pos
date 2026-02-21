<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Retail POS', 'slug' => 'retail-pos', 'description' => 'Solutions for retail stores.', 'image' => 'img/defaults/placeholder.svg', 'sort_order' => 1, 'is_active' => true],
            ['name' => 'Restaurant POS', 'slug' => 'restaurant-pos', 'description' => 'Solutions for restaurants and cafes.', 'image' => 'img/defaults/placeholder.svg', 'sort_order' => 2, 'is_active' => true],
            ['name' => 'ERP Integrations', 'slug' => 'erp-integrations', 'description' => 'ERP and accounting integrations.', 'image' => 'img/defaults/placeholder.svg', 'sort_order' => 3, 'is_active' => true],
        ];

        foreach ($rows as $row) {
            Category::updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
