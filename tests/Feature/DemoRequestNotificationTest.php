<?php

namespace Tests\Feature;

use App\Mail\DemoRequestSubmitted;
use App\Models\ServiceRequest;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class DemoRequestNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('services.demo_requests.recipient', 'notifications@example.test');
        Mail::fake();
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'type' => 'demo_request',
            'full_name' => 'Demo Audit Customer',
            'email' => 'customer@example.test',
            'phone' => '+962790000000',
            'company' => 'Audit Test Company',
            'country' => 'Jordan',
            'product_interest' => 'Multi-branch POS',
            'branch_count' => 2,
            'preferred_contact_time' => '10:00 Asia/Amman',
            'message' => 'Please arrange a product demonstration.',
            'source_page' => '/request-product-demo',
        ], $overrides);
    }

    public function test_success_stores_request_sends_once_and_refresh_does_not_resend_or_repeat_success_event(): void
    {
        $response = $this->from('/request-product-demo')->post(route('requests.store'), $this->payload());
        $request = ServiceRequest::sole();
        $response->assertRedirect('/request-product-demo')->assertSessionHasNoErrors()
            ->assertSessionHas('success')->assertSessionMissing('warning')
            ->assertSessionHas('tracking_event.event_id', 'service_request_'.$request->id);
        $this->assertDatabaseHas('service_requests', ['id' => $request->id, ...$this->payload()]);
        Mail::assertSent(DemoRequestSubmitted::class, fn ($mail) => $mail->hasTo('notifications@example.test')
            && $mail->serviceRequest->id === $request->id);
        Mail::assertSentCount(1);
        Mail::assertNothingQueued();

        $this->get('/request-product-demo')->assertOk()->assertSee('window.aquaTrackEvent("generate_lead",', false);
        $this->get('/request-product-demo')->assertOk()->assertDontSee('window.aquaTrackEvent("generate_lead",', false);
        Mail::assertSentCount(1);
        $this->assertDatabaseCount('service_requests', 1);
    }

    public function test_invalid_submission_shows_errors_preserves_input_and_emits_no_lead_or_email(): void
    {
        $this->from('/request-product-demo')->post(route('requests.store'), $this->payload([
            'email' => 'not-an-email', 'branch_count' => 0,
        ]))->assertRedirect('/request-product-demo')
            ->assertSessionHasErrors(['email', 'branch_count'])->assertSessionMissing('tracking_event');
        $this->get('/request-product-demo')->assertOk()->assertSee('alert-danger', false)
            ->assertSee('value="Demo Audit Customer"', false)
            ->assertSee('Please arrange a product demonstration.')
            ->assertDontSee('window.aquaTrackEvent("generate_lead",', false);
        Mail::assertNothingSent();
        $this->assertDatabaseCount('service_requests', 0);
    }

    public function test_required_name_failure_dispatches_nothing(): void
    {
        $this->post(route('requests.store'), $this->payload(['full_name' => '']))
            ->assertSessionHasErrors('full_name')->assertSessionMissing('tracking_event');
        Mail::assertNothingSent();
        $this->assertDatabaseCount('service_requests', 0);
    }

    public function test_configured_recipient_is_used_without_hardcoded_fallback(): void
    {
        config()->set('services.demo_requests.recipient', 'different-recipient@example.test');
        $this->post(route('requests.store'), $this->payload())->assertSessionHasNoErrors();
        Mail::assertSent(DemoRequestSubmitted::class, fn ($mail) => $mail->hasTo('different-recipient@example.test'));
        Mail::assertSentCount(1);
    }

    public function test_missing_or_invalid_recipient_preserves_request_but_warns_without_dispatch(): void
    {
        Log::spy();
        foreach ([null, '', 'invalid-address'] as $recipient) {
            config()->set('services.demo_requests.recipient', $recipient);
            $this->from('/request-product-demo')->post(route('requests.store'), $this->payload())
                ->assertRedirect('/request-product-demo')->assertSessionMissing('success')
                ->assertSessionHas('warning')->assertSessionHas('tracking_event');
            $this->get('/request-product-demo')->assertOk()->assertSee('alert-warning', false)
                ->assertSee('email notification could not be sent');
        }
        Mail::assertNothingSent();
        $this->assertDatabaseCount('service_requests', 3);
        Log::shouldHaveReceived('error')->times(3)->withArgs(fn ($message, $context) => $context['reason'] === 'invalid_recipient_configuration' && ! isset($context['exception']));
    }

    public function test_transport_failure_warns_without_losing_saved_request_or_logging_secrets(): void
    {
        Log::spy();
        $pendingMail = \Mockery::mock(\Illuminate\Mail\PendingMail::class);
        $pendingMail->shouldReceive('send')->once()->with(\Mockery::type(DemoRequestSubmitted::class))
            ->andThrow(new \RuntimeException('secret SMTP password must not enter the logs'));
        Mail::shouldReceive('to')->once()->with('notifications@example.test')
            ->andReturn($pendingMail);
        $this->from('/request-product-demo')->post(route('requests.store'), $this->payload())
            ->assertRedirect('/request-product-demo')->assertSessionMissing('success')
            ->assertSessionHas('warning')->assertSessionHas('tracking_event');
        $this->assertDatabaseCount('service_requests', 1);
        Log::shouldHaveReceived('error')->once()->withArgs(fn ($message, $context) => $context['reason'] === 'mail_dispatch_failed'
            && $context['exception_class'] === \RuntimeException::class
            && ! str_contains(json_encode($context), 'secret SMTP password'));
    }

    public function test_logging_failure_cannot_undo_saved_request(): void
    {
        Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('transport failed'));
        Log::shouldReceive('error')->once()->andThrow(new \RuntimeException('log unavailable'));
        $this->post(route('requests.store'), $this->payload())
            ->assertRedirect()->assertSessionHas('warning');
        $this->assertDatabaseCount('service_requests', 1);
    }

    public function test_email_content_is_complete_escaped_and_uses_reply_to_instead_of_customer_sender(): void
    {
        $this->travelTo(now()->setDate(2026, 11, 7)->setTime(12, 34, 56));
        $this->post(route('requests.store'), $this->payload([
            'company' => '<script>unsafe-company</script>',
            'message' => '<img src=x onerror=alert(1)>',
        ]))->assertSessionHasNoErrors();
        Mail::assertSent(DemoRequestSubmitted::class, function ($mail) {
            $html = $mail->render();
            foreach (['Demo Audit Customer', 'customer@example.test', '+962790000000', 'Jordan',
                'Multi-branch POS', '10:00 Asia/Amman', '2026-11-07 12:34:56',
                '&lt;script&gt;unsafe-company&lt;/script&gt;', '&lt;img src=x onerror=alert(1)&gt;'] as $value) {
                $this->assertStringContainsString($value, $html);
            }
            $this->assertStringNotContainsString('<script>unsafe-company</script>', $html);
            $this->assertNull($mail->envelope()->from);
            $this->assertSame('customer@example.test', $mail->envelope()->replyTo[0]->address);

            return true;
        });
    }

    public function test_optional_fields_can_be_missing_without_breaking_email(): void
    {
        $this->post(route('requests.store'), ['type' => 'demo_request', 'full_name' => 'Minimal Demo'])
            ->assertSessionHasNoErrors()->assertSessionHas('success');
        Mail::assertSent(DemoRequestSubmitted::class, function ($mail) {
            $this->assertStringContainsString('Not provided', $mail->render());
            $this->assertSame([], $mail->envelope()->replyTo);

            return true;
        });
        Mail::assertSentCount(1);
    }

    public function test_successful_demo_lead_executes_once_in_all_google_modes(): void
    {
        $node = (new ExecutableFinder)->find('node');
        if (! $node) {
            $this->markTestSkipped('Node.js is required for the tracking runtime check.');
        }
        $setting = SiteSetting::create([
            'key' => 'general', 'site_name' => 'AQUA POS', 'ga4_measurement_id' => 'G-DIRECT123',
            'gtm_container_id' => 'GTM-ACTIVE123', 'meta_pixel_id' => '123456789012345',
            'ms_clarity_project_id' => 'abc123xyz',
        ]);
        $pages = [];
        foreach (['none', 'ga4', 'gtm'] as $method) {
            $setting->update(['tracking_method' => $method]);
            $this->from('/request-product-demo')->post(route('requests.store'), $this->payload())
                ->assertSessionHasNoErrors();
            $pages[$method] = $this->get('/request-product-demo')->assertOk()->getContent();
        }
        $process = new Process([$node, base_path('tests/Support/tracking-runtime.cjs')]);
        $process->setInput(json_encode($pages, JSON_THROW_ON_ERROR));
        $process->run();
        $this->assertTrue($process->isSuccessful(), $process->getOutput().$process->getErrorOutput());
        Mail::assertSentCount(3);
    }
}
