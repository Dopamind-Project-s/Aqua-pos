<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductLocalizationTest extends TestCase
{
    public function test_product_key_features_follow_current_locale(): void
    {
        $product = new Product([
            'key_features' => ['Legacy English'],
            'key_features_ar' => ['ميزة عربية'],
            'key_features_en' => ['English feature'],
        ]);

        app()->setLocale('ar');
        $this->assertSame(['ميزة عربية'], $product->localized_key_features);

        app()->setLocale('en');
        $this->assertSame(['English feature'], $product->localized_key_features);
    }

    public function test_product_key_features_fall_back_to_legacy_features(): void
    {
        $product = new Product([
            'key_features' => ['Legacy feature'],
        ]);

        app()->setLocale('ar');
        $this->assertSame(['Legacy feature'], $product->localized_key_features);
    }
}
