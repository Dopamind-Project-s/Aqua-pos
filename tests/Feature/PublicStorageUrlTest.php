<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Client;
use App\Models\Post;
use App\Models\Product;
use Tests\TestCase;

class PublicStorageUrlTest extends TestCase
{
    public function test_public_storage_url_uses_domain_relative_paths_for_uploaded_files(): void
    {
        $this->assertSame('/storage/products/demo.jpg', public_storage_url('products/demo.jpg'));
        $this->assertSame('/storage/products/demo.jpg', public_storage_url('/storage/products/demo.jpg'));
    }

    public function test_public_storage_url_keeps_public_assets_as_public_paths(): void
    {
        $this->assertSame('/img/defaults/placeholder.svg', public_storage_url('img/defaults/placeholder.svg'));
    }

    public function test_model_image_accessors_use_public_storage_urls(): void
    {
        $this->assertSame('/storage/products/demo.jpg', (new Product(['image' => 'products/demo.jpg']))->image_url);
        $this->assertSame('/storage/categories/demo.jpg', (new Category(['image' => 'categories/demo.jpg']))->image_url);
        $this->assertSame('/storage/clients/demo.jpg', (new Client(['logo' => 'clients/demo.jpg']))->logo_url);
        $this->assertSame('/storage/posts/demo.jpg', (new Post(['cover_image' => 'posts/demo.jpg']))->cover_image_url);
    }
}
