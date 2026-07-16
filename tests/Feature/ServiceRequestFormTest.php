<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceRequestFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_support_form_contains_country_before_phone_and_company_in_one_desktop_row(): void
    {
        $response = $this->get(route('support'));

        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('id="supportCountryDisplay"', $content);
        $this->assertStringContainsString('name="country"', $content);
        $this->assertStringContainsString('class="col-md-4 "', $content);
        $this->assertLessThan(strpos($content, 'name="phone"'), strpos($content, 'name="country"'));
        $this->assertLessThan(strpos($content, 'name="company"'), strpos($content, 'name="phone"'));
    }

    public function test_demo_form_places_country_and_phone_together_then_company_below(): void
    {
        $response = $this->get(route('request-product-demo'));

        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('id="demoCountryDisplay"', $content);
        $this->assertStringContainsString('class="col-md-6 demo-input-group"', $content);
        $this->assertLessThan(strpos($content, 'name="phone"'), strpos($content, 'name="country"'));
        $this->assertLessThan(strpos($content, 'name="company"'), strpos($content, 'name="phone"'));
        $this->assertLessThan(strpos($content, 'name="branch_count"'), strpos($content, 'name="company"'));
    }

    public function test_contact_form_contains_country_before_phone_and_company(): void
    {
        $response = $this->get(route('contact'));

        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('id="contactCountryDisplay"', $content);
        $this->assertLessThan(strpos($content, 'name="phone"'), strpos($content, 'name="country"'));
        $this->assertLessThan(strpos($content, 'name="company"'), strpos($content, 'name="phone"'));
    }

    public function test_support_request_persists_selected_country(): void
    {
        $this->post(route('requests.store'), [
            'type' => 'support_request',
            'full_name' => 'Support Customer',
            'country' => 'Jordan',
            'phone' => '+962791234567',
            'company' => 'Aqua Customer',
            'source_page' => '/support',
        ])->assertRedirect();

        $this->assertDatabaseHas('service_requests', [
            'type' => 'support_request',
            'country' => 'Jordan',
            'phone' => '+962791234567',
            'company' => 'Aqua Customer',
        ]);
    }
}
