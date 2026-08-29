<?php

namespace Tests\Feature\Admin;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ga4_can_be_selected_and_google_ids_are_normalized(): void
    {
        $setting = $this->setting();

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'ga4',
                'ga4_measurement_id' => '  g-test123  ',
                'gtm_container_id' => '  gtm-saved456  ',
            ])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHasNoErrors();

        $setting->refresh();
        $this->assertSame('ga4', $setting->tracking_method);
        $this->assertSame('G-TEST123', $setting->ga4_measurement_id);
        $this->assertSame('GTM-SAVED456', $setting->gtm_container_id);
    }

    public function test_ga4_requires_a_valid_measurement_id(): void
    {
        $this->setting();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.settings.edit'))
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'ga4',
                'ga4_measurement_id' => '',
            ])
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHasErrors('ga4_measurement_id');

        $this->actingAs($admin)
            ->from(route('admin.settings.edit'))
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'ga4',
                'ga4_measurement_id' => 'abc',
            ])
            ->assertSessionHasErrors('ga4_measurement_id');
    }

    public function test_gtm_requires_a_valid_container_id(): void
    {
        $this->setting();
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.settings.edit'))
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'gtm',
                'gtm_container_id' => '',
            ])
            ->assertSessionHasErrors('gtm_container_id');

        $this->actingAs($admin)
            ->from(route('admin.settings.edit'))
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'gtm',
                'gtm_container_id' => 'abc',
            ])
            ->assertSessionHasErrors('gtm_container_id');
    }

    public function test_gtm_with_a_valid_id_succeeds(): void
    {
        $this->setting();

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'gtm',
                'gtm_container_id' => 'gtm-test123',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('site_settings', [
            'tracking_method' => 'gtm',
            'gtm_container_id' => 'GTM-TEST123',
        ]);
    }

    public function test_none_needs_no_id_and_retains_saved_ids(): void
    {
        $setting = $this->setting([
            'ga4_measurement_id' => 'G-SAVED123',
            'gtm_container_id' => 'GTM-SAVED123',
        ]);

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'none',
                'ga4_measurement_id' => 'G-SAVED123',
                'gtm_container_id' => 'GTM-SAVED123',
            ])
            ->assertSessionHasNoErrors();

        $setting->refresh();
        $this->assertSame('none', $setting->tracking_method);
        $this->assertSame('G-SAVED123', $setting->ga4_measurement_id);
        $this->assertSame('GTM-SAVED123', $setting->gtm_container_id);
    }

    public function test_direct_ga4_is_exclusive_and_escapes_the_id(): void
    {
        $this->setting([
            'tracking_method' => 'ga4',
            'ga4_measurement_id' => 'G-DIRECT123',
            'gtm_container_id' => 'GTM-SAVED123',
        ]);

        $response = $this->get(route('home'))->assertOk();

        $response->assertSee('gtag/js?id=G-DIRECT123', false)
            ->assertSee("window.gtag('config', \"G-DIRECT123\")", false)
            ->assertDontSee('gtm.js?id=', false)
            ->assertDontSee('ns.html?id=GTM-SAVED123', false);
        $this->assertSame(1, substr_count($response->getContent(), 'gtag/js?id=G-DIRECT123'));
    }

    public function test_gtm_is_exclusive_and_legacy_null_method_still_uses_gtm(): void
    {
        $setting = $this->setting([
            'tracking_method' => 'gtm',
            'ga4_measurement_id' => 'G-SAVED123',
            'gtm_container_id' => 'GTM-ACTIVE123',
        ]);

        $response = $this->get(route('home'))->assertOk();
        $response->assertSee('GTM-ACTIVE123', false)
            ->assertSee('gtm.js', false)
            ->assertDontSee('gtag/js?id=', false);

        $setting->forceFill(['tracking_method' => null])->save();
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('GTM-ACTIVE123', false)
            ->assertSee('gtm.js', false)
            ->assertDontSee('gtag/js?id=', false);
    }

    public function test_none_loads_neither_google_runtime_and_tracker_is_safe(): void
    {
        $this->setting([
            'tracking_method' => 'none',
            'ga4_measurement_id' => 'G-SAVED123',
            'gtm_container_id' => 'GTM-SAVED123',
        ]);

        $response = $this->get(route('home'))->assertOk();
        $response->assertSee('window.aquaTrackEvent', false)
            ->assertSee('window.AQUA_TRACKING_METHOD = "none"', false)
            ->assertDontSee('gtag/js?id=', false)
            ->assertDontSee('gtm.js?id=', false)
            ->assertDontSee('ns.html?id=', false);
    }

    public function test_invalid_or_malicious_id_is_rejected_and_not_persisted(): void
    {
        $setting = $this->setting();

        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'ga4',
                'ga4_measurement_id' => 'G-TEST</script><script>alert(1)</script>',
            ])
            ->assertSessionHasErrors('ga4_measurement_id');

        $this->assertNull($setting->refresh()->ga4_measurement_id);
    }

    public function test_generate_lead_uses_the_central_tracker_once_after_success(): void
    {
        $this->setting([
            'tracking_method' => 'ga4',
            'ga4_measurement_id' => 'G-DIRECT123',
        ]);

        $response = $this->followingRedirects()->post(route('requests.store'), [
            'type' => 'support_request',
            'full_name' => 'Tracking Test',
            'country' => 'Jordan',
            'phone' => '+962791234567',
            'company' => 'Aqua Customer',
            'source_page' => '/support',
        ])->assertOk();

        $content = $response->getContent();
        $this->assertStringContainsString('window.aquaTrackEvent("generate_lead",', $content);
        $this->assertSame(1, substr_count($content, 'window.aquaTrackEvent("generate_lead",'));
        $this->assertStringContainsString('"form_type":"support_request"', $content);
        $this->assertStringContainsString('"source_page":"/support"', $content);
        $this->assertStringNotContainsString('Tracking Test', $content);
        $this->assertStringNotContainsString('+962791234567', $content);
    }

    private function setting(array $attributes = []): SiteSetting
    {
        return SiteSetting::query()->create(array_merge([
            'key' => 'general',
            'site_name' => 'AQUA POS',
            'tracking_method' => 'none',
        ], $attributes));
    }
}
