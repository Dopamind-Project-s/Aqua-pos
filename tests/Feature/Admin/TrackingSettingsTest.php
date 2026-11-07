<?php

namespace Tests\Feature\Admin;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;
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
        Mail::fake();
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
        $this->assertStringContainsString('"source_page":"\\/support"', $content);
        $this->assertStringNotContainsString('Tracking Test', $content);
        $this->assertStringNotContainsString('+962791234567', $content);
    }

    public function test_independent_integrations_render_once_on_public_pages_in_every_google_mode(): void
    {
        $setting = $this->setting([
            'ga4_measurement_id' => 'G-DIRECT123',
            'gtm_container_id' => 'GTM-ACTIVE123',
            'meta_pixel_id' => '123456789012345',
            'google_site_verification' => 'Test_token-123',
            'search_console_property' => 'sc-domain:example.com',
            'ms_clarity_project_id' => 'abc123xyz',
        ]);

        foreach (['none', 'ga4', 'gtm'] as $method) {
            $setting->update(['tracking_method' => $method]);
            foreach (['/', '/about', '/blog', '/news', '/products', '/contact', '/support'] as $path) {
                $html = $this->get($path)->assertOk()->getContent();
                $head = substr($html, 0, strpos($html, '</head>'));
                $this->assertSame(1, substr_count($head, '<meta name="google-site-verification" content="Test_token-123">'));
                $this->assertSame(1, substr_count($head, 'https://connect.facebook.net/en_US/fbevents.js'));
                $this->assertSame(1, substr_count($head, "window.fbq('init', \"123456789012345\")"));
                $this->assertSame(1, substr_count($head, "window.fbq('trackSingle', \"123456789012345\", 'PageView')"));
                $this->assertSame(1, substr_count($html, 'facebook.com/tr?id=123456789012345&amp;ev=PageView&amp;noscript=1'));
                $this->assertSame(1, substr_count($head, 'https://www.clarity.ms/tag/'));
                $this->assertStringNotContainsString('sc-domain:example.com', $head);
                $this->assertSame($method === 'ga4' ? 1 : 0, substr_count($html, 'gtag/js?id='));
                $this->assertSame($method === 'gtm' ? 1 : 0, substr_count($html, 'ns.html?id='));
            }
        }
    }

    public function test_admin_saves_independent_values_and_next_public_response_uses_updates(): void
    {
        $this->setting(['meta_pixel_id' => '111111111', 'google_site_verification' => 'old-token']);
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin)->put(route('admin.settings.update'), [
            'site_name' => 'AQUA POS',
            'tracking_method' => 'none',
            'meta_pixel_id' => '222222222',
            'google_site_verification' => 'new_token-123',
            'search_console_property' => 'https://example.com/',
            'ms_clarity_project_id' => 'new123',
        ])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('site_settings', [
            'meta_pixel_id' => '222222222',
            'google_site_verification' => 'new_token-123',
            'search_console_property' => 'https://example.com/',
            'ms_clarity_project_id' => 'new123',
        ]);
        $this->app['auth']->forgetGuards();
        $this->get('/')->assertOk()
            ->assertSee('facebook.com/tr?id=222222222', false)
            ->assertSee('content="new_token-123"', false)
            ->assertDontSee('old-token', false)
            ->assertDontSee('facebook.com/tr?id=111111111', false);
    }

    public function test_full_snippets_and_dns_records_are_rejected_in_token_and_id_fields(): void
    {
        $this->setting();
        $this->actingAs(User::factory()->admin()->create())
            ->put(route('admin.settings.update'), [
                'site_name' => 'AQUA POS',
                'tracking_method' => 'none',
                'meta_pixel_id' => '<script>fbq()</script>',
                'google_site_verification' => 'google-site-verification=abc123',
                'ms_clarity_project_id' => 'abc\\xyz',
            ])->assertSessionHasErrors(['meta_pixel_id', 'google_site_verification', 'ms_clarity_project_id']);
    }

    public function test_legacy_invalid_ids_do_not_generate_scripts_and_tokens_remain_html_escaped(): void
    {
        $this->setting([
            'meta_pixel_id' => '123</script>',
            'ms_clarity_project_id' => 'abc\\xyz',
            'google_site_verification' => 'a"&<b',
        ]);
        $this->get('/')->assertOk()
            ->assertDontSee('connect.facebook.net', false)
            ->assertDontSee('clarity.ms/tag/', false)
            ->assertSee('content="a&quot;&amp;&lt;b"', false);
    }

    public function test_environment_fallbacks_and_database_precedence(): void
    {
        config()->set('services.google.site_verification', 'env_token');
        config()->set('services.clarity.project_id', 'env123');
        $setting = $this->setting();
        $this->get('/')->assertOk()->assertSee('content="env_token"', false)->assertSee('"env123"', false);
        $setting->update(['google_site_verification' => 'db_token', 'ms_clarity_project_id' => 'db123']);
        $this->get('/')->assertOk()->assertSee('content="db_token"', false)->assertSee('"db123"', false)
            ->assertDontSee('content="env_token"', false)->assertDontSee('"env123"', false);
    }

    public function test_rendered_tracking_javascript_executes_and_meta_bootstrap_is_idempotent(): void
    {
        $node = (new ExecutableFinder)->find('node');
        if (! $node) {
            $this->markTestSkipped('Node.js is required for the tracking runtime check.');
        }
        $setting = $this->setting([
            'ga4_measurement_id' => 'G-DIRECT123',
            'gtm_container_id' => 'GTM-ACTIVE123',
            'meta_pixel_id' => '123456789012345',
            'ms_clarity_project_id' => 'abc123xyz',
        ]);
        $pages = [];
        foreach (['none', 'ga4', 'gtm'] as $method) {
            $setting->update(['tracking_method' => $method]);
            $pages[$method] = $this->get('/')->assertOk()->getContent();
        }
        $setting->update(['tracking_method' => 'none', 'meta_pixel_id' => null]);
        $pages['withoutPixel'] = $this->get('/')->assertOk()->getContent();
        $process = new Process([$node, base_path('tests/Support/tracking-runtime.cjs')]);
        $process->setInput(json_encode($pages, JSON_THROW_ON_ERROR));
        $process->run();
        $this->assertTrue($process->isSuccessful(), $process->getOutput().$process->getErrorOutput());
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
