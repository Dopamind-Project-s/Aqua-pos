<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_public_named_routes_are_accessible(): void
    {
        foreach ([
            'home',
            'about',
            'blog',
            'news',
            'products',
            'clients.index',
            'partners.index',
            'contact',
            'support',
            'request-product-demo',
        ] as $routeName) {
            $this->get(route($routeName))->assertOk();
        }
    }

    public function test_team_path_is_accessible(): void
    {
        $this->get('/team')
            ->assertOk();
    }
}
