<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CatalogStressSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogStressSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_stress_seeder_creates_twelve_categories_and_twelve_products(): void
    {
        $this->seed(CatalogStressSeeder::class);

        $targetCategory = Category::query()->where('slug', 'demo-category-01')->firstOrFail();

        $this->assertSame(12, Category::query()->where('slug', 'like', 'demo-category-%')->count());
        $this->assertSame(12, Product::query()->where('slug', 'like', 'demo-product-%')->count());
        $this->assertSame(
            12,
            $targetCategory->products()
                ->where('is_active', true)
                ->whereNull('deleted_at')
                ->count()
        );
    }
}
