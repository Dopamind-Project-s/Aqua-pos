<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CatalogStressSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect(range(1, 12))->map(fn (int $number): array => [
            'slug' => sprintf('demo-category-%02d', $number),
            'name' => sprintf('Demo Category %02d', $number),
            'name_en' => sprintf('Demo Category %02d', $number),
            'name_ar' => sprintf('Demo Category %02d', $number),
            'description' => sprintf('Stress test category number %02d for catalog and CMS checks.', $number),
            'description_en' => sprintf('Stress test category number %02d for catalog and CMS checks.', $number),
            'description_ar' => sprintf('Stress test category number %02d for catalog and CMS checks.', $number),
            'image' => 'img/defaults/placeholder.svg',
            'sort_order' => 100 + $number,
            'is_active' => true,
        ]);

        $categories->each(fn (array $category): Category => Category::query()->updateOrCreate(
            ['slug' => $category['slug']],
            $category
        ));

        $targetCategory = Category::query()->where('slug', 'demo-category-01')->firstOrFail();

        collect(range(1, 12))->each(function (int $number) use ($targetCategory): void {
            $product = [
                'category_id' => $targetCategory->id,
                'slug' => sprintf('demo-product-%02d', $number),
                'name' => sprintf('Demo Product %02d', $number),
                'name_en' => sprintf('Demo Product %02d', $number),
                'name_ar' => sprintf('Demo Product %02d', $number),
                'tagline' => sprintf('Catalog stress product %02d.', $number),
                'tagline_en' => sprintf('Catalog stress product %02d.', $number),
                'tagline_ar' => sprintf('Catalog stress product %02d.', $number),
                'short_description' => sprintf('Active product %02d used to verify category lists over six items.', $number),
                'short_description_en' => sprintf('Active product %02d used to verify category lists over six items.', $number),
                'short_description_ar' => sprintf('Active product %02d used to verify category lists over six items.', $number),
                'description' => sprintf('Demo Product %02d confirms that the frontend can display more than six products under one category.', $number),
                'description_en' => sprintf('Demo Product %02d confirms that the frontend can display more than six products under one category.', $number),
                'description_ar' => sprintf('Demo Product %02d confirms that the frontend can display more than six products under one category.', $number),
                'key_features' => ['Catalog visibility', 'CMS verification', 'Active product'],
                'use_cases' => 'Used for QA and catalog display validation.',
                'use_cases_en' => 'Used for QA and catalog display validation.',
                'use_cases_ar' => 'Used for QA and catalog display validation.',
                'image' => 'img/defaults/placeholder.svg',
                'price' => 100 + $number,
                'price_note' => 'Demo price',
                'sort_order' => $number,
                'is_featured' => $number <= 3,
                'is_active' => true,
                'deleted_at' => null,
            ];

            Product::query()->withTrashed()->updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        });
    }
}
