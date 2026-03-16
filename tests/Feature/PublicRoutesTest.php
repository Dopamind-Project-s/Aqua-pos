<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    public function test_core_public_named_routes_are_accessible(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('about'))->assertOk();
        $this->get(route('service'))->assertOk();
        $this->get(route('appointment'))->assertOk();
        $this->get(route('feature'))->assertOk();
        $this->get(route('testimonial'))->assertOk();
        $this->get(route('clients.index'))->assertOk();
    }

    public function test_legacy_team_path_redirects_to_clients(): void
    {
        $this->get('/team')
            ->assertRedirect('/clients');
    }
}
