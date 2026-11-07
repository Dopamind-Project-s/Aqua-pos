# Final tracking and demo request email audit

7 November 2026. This report supplements [the detailed tracking audit](tracking-integration-audit.md). Scope: current source diff, automated Laravel tests, isolated Chrome execution and one actual configured-mail-transport dispatch through the HTTP form flow. No client production deployment, DNS or third-party account was accessed or modified.

Subsequent [production-readiness follow-up](production-readiness.md): the stale route test is fixed and the full suite now passes (57 tests, 495 assertions). An SMTP environment template is available; delivery remains blocked by the log-only configuration. The results below retain the earlier audit's evidence.

## Tracking integrations

| Integration | Code status | Issues | Fixes | Remaining actions |
|---|---|---|---|---|
| GA4 | Correct direct loader/configuration; exclusive with GTM | No confirmed source defect; production receipt unknown | Regression checks retained | Confirm collection requests and GA4 Realtime/DebugView on the deployed domain |
| GTM | Correct head bootstrap/body fallback; disabled in direct/none mode | Published container contents and duplicate downstream tags unknown | Regression checks retained | Inspect/publish tags, consent settings and triggers; one owner per integration |
| Search Console | One initial public-head verification meta tag; independent of Google mode | Domain Property TXT failure is external DNS verification, not an HTML-tag failure | Prior token validation fix reviewed | Add the exact Google TXT value at authoritative DNS for Domain Property, or use the correct URL-prefix HTML method; do not replace SPF |
| Meta Pixel | Independent PageView and successful-demo Lead are locally verified | Recent Lead bridge broadcast every `generate_lead`, including support/contact, to every initialized Pixel; no repeat guard | Target configured native Pixel with `trackSingle`; require demo type plus stable submission event ID; suppress repeated Lead callback; no native Lead when native ID is empty | Verify SDK loading, one PageView/Lead and receipt in Meta Test Events; remove equivalent GTM tags when native tracking owns the Pixel |
| Google Ads | IDs/label remain storage-only; existing roadmap delegates conversions to GTM | Saving fields does not create an Ads tag/conversion | Existing admin clarification retained; no speculative paid-conversion mapping | Configure the intended conversion action, Google tag/Conversion Linker and filtered trigger in GTM, or explicitly import the intended GA4 key event |
| Microsoft Clarity | Independent loader; validation/JSON serialization/head placement reviewed | No demonstrated local conflict; external receipt unknown | Prior fixes and tests retained | Check collection requests, intended Clarity project, consent and duplicate GTM installation |

`none` suppresses native GA4/GTM and their event routing, not Meta, the verification tag or Clarity. No application CMP or CSP policy was found; production header policy, externally injected consent controls, CDN caches and blockers remain unverified. Settings are read from the database on rendering. Environment fallbacks require refreshed configuration cache when changed. The prior audit provides the exact DevTools, GA4, Search Console and Meta verification checklists.

### Meta Lead behavior

`ServiceRequestController::store()` supplies `event_id = service_request_<stored ID>` only after validation and persistence. The layout forwards successful **demo** `generate_lead` events to the configured native Pixel with a targeted `Lead` and Meta `eventID`. Only `form_type` is forwarded to Meta; customer email, name, phone and free text are not included in the Lead parameters.

A per-document guard prevents a repeated callback for the same event ID from queuing another Meta Lead. PageView has its own initialization guard. Successful request events use one-time session flash data; an ordinary subsequent refresh has no success callback and does not send another notification. A saved demo still counts as a submission when its notification fails, with a visible mail warning.

When the native Pixel field is empty, this bridge does not send into an externally managed `fbq`; GTM must own its complete Pixel configuration. App guards cannot deduplicate separately authored GTM tags or prevent two intentionally separate POST submissions from creating two requests. There is no cross-request idempotency key or automatic mail retry. Do not cache session-personalized success HTML at the CDN.

## Demo request flow and findings

The actual flow is:

`GET /request-product-demo` → CSRF-protected POST form → `POST /requests` → `StoreServiceRequest` validation → `ServiceRequest::create()` → synchronous `Mail::to(config('services.demo_requests.recipient'))->send(new DemoRequestSubmitted(...))` → configured transport → redirect and flashed tracking event.

- Form: `resources/views/requests/demo.blade.php`. Submission is a normal browser POST, not AJAX. `public/js/main.js` provides translations/country behavior; no second mail dispatch exists there.
- Routes: `routes/web.php`. Both form and submission are public web routes; normal CSRF/session middleware applies.
- Validation: `app/Http/Requests/StoreServiceRequest.php`. Demo type/name required; email optional but validated when supplied; branch count must be an integer of at least one. The remaining business/contact fields are optional. These semantics match the form.
- Persistence: `app/Models/ServiceRequest.php` and existing migrations. The notification occurs after the record is saved. A mail failure does not discard the customer request.
- Recipient: `config/services.php` reads `DEMO_REQUEST_RECIPIENT`. No runtime `env()` call is used by the controller or Mailable. The hardcoded client-address fallback was removed; missing/invalid recipient now causes a logged configuration error and visible warning without dispatch.
- Mailable/template: `app/Mail/DemoRequestSubmitted.php` and `resources/views/emails/service-requests/demo-submitted.blade.php`. The notification includes name, email, phone, company, country, product interest, subject, branches, preferred time, message and submission timestamp. Values are Blade-escaped, optional fields have placeholders, and the existing table layout renders successfully.
- Sender: inherited from `mail.from`; customer email is used only as Reply-To when supplied. Actual transport-test inspection confirmed that distinction.
- Queue: `send()` is synchronous. The Mailable uses `Queueable` but does not implement `ShouldQueue`; no job or queue worker is involved in this notification path.
- Error handling: exceptions preserve saved requests. Failure previously used the success/green notice channel; it now uses a warning rendered on both demo and support forms. Logs contain request ID/type, reason and exception class rather than the raw exception, which can expose credentials or provider dialogue. A broken logger still cannot undo the saved request.
- Validation UX: the demo previously did not show server validation errors and lost several submitted fields. It now displays errors and retains entered values after rejection.

No schema, mail credential, environment file or production worker changes were needed or performed.

## Actual mail transport test

| Check | Observed result |
|---|---|
| Test recipient | `musab.m.alzoubii@gmail.com`, process-only override |
| Configured transport | `MAIL_MAILER=log`; `Illuminate\Mail\Transport\LogTransport` |
| SMTP readiness in this checkout | SMTP configuration points to loopback, has no username/password or mail URL; sender is an example-domain placeholder |
| Actual flow attempted | Yes: GET form, extract CSRF/session cookies, POST a synthetic realistic demo, follow redirect; no `Mail::fake()` in this test |
| Form / submission response | HTTP 200 / HTTP 302 |
| Database effect | Exactly one request in isolated SQLite `:memory:`; no client database row created |
| Notification dispatch | Exactly one `MessageSending` and one `MessageSent` event |
| Envelope safety | Recipient guard allowed only the requested test address and no CC/BCC; sender matched configuration; Reply-To matched test customer |
| Mail log | Exactly one matching synthetic-test Subject entry in `storage/logs/laravel.log` |
| Redirect / refresh | Success callback appeared once; refresh callback count zero; notification count stayed one |
| SMTP/provider acceptance | **Not achieved or observed.** LogTransport does not contact an SMTP/provider endpoint |
| Inbox delivery | **Not independently confirmed.** No delivered email is claimed |
| Original recipient restored | Yes, restored in process; original `.env` hash unchanged |
| Configuration cache | Isolated `config:cache` succeeded and reloaded the original client recipient correctly; temporary cache deleted; application's normal cache state unchanged |

This test proves application processing and dispatch through the **actual configured transport**, which writes a message to a log. It is not a real SMTP-delivery test. No switch to another mailer was made, no credentials were invented, and no test was sent to the client address. Configuring a real provider is the blocker to completing the requested inbox test.

The isolated configuration-cache file was created in a private `/tmp` directory and deleted after verification; its contents were not printed. Only recipient-match/cache-status checks were reported. Runtime diagnostics did not print SMTP credentials or raw provider errors.

## Tests and browser evidence

- **33 relevant tests, 423 assertions passed** across `TrackingSettingsTest`, `ServiceRequestFormTest` and new `DemoRequestNotificationTest`.
- Coverage includes successful persistence, required/invalid input, configured/custom/missing/invalid recipients, one notification, no queue job, complete escaped template, optional values, sender/Reply-To, dispatch failure, logger failure, warning display, refresh behavior, actual rendered demo Lead callbacks and duplicate suppression in all three Google modes.
- Automated mail-success tests use `Mail::fake()`. Failure cases mock an exception at dispatch; the separate actual-transport test above does not fake mail.
- Node executes the rendered inline scripts, checking bootstrap queues, independent modes, targeting and repeated callback behavior. An existing externally managed `fbq` receives no native Lead when the native Pixel field is empty.
- Headless Chrome executed successful demo responses under `none`, `ga4`, `gtm`: each showed one Pixel initialization, one PageView and one Lead after repeating the callback. Event IDs were `service_request_1`, `_2`, `_3`; only direct GA4 had a `gtag` config, and all had the expected initial verification token. External hostname resolution was blocked: these checks prove local JS execution/queueing, not third-party SDK downloads or provider receipt. Mail in these separate automated browser fixtures was faked.
- Full suite: **57 tests; 56 passed, one existing unrelated route error**, `tests/Feature/PublicRoutesTest.php:13` references nonexistent route `service`. Routes were not changed. The final targeted run after improving the send-failure mock passed.
- Pint and `git diff --check` passed. CLI PHP lacks PDO SQLite, so tests loaded an extracted compatible extension from `/tmp` for individual processes; no system PHP installation changed.

Reproduce targeted tests with PDO SQLite enabled:

```bash
php vendor/bin/phpunit --filter 'DemoRequestNotificationTest|TrackingSettingsTest|ServiceRequestFormTest'
```

The runtime JavaScript checks additionally require Node.js; those tests explicitly skip when Node is unavailable.

## Files changed

| File | Purpose |
|---|---|
| `app/Http/Controllers/ServiceRequestController.php` | Validate recipient, warn on mail failure, sanitize failure logging and attach stable event ID |
| `config/services.php` | Remove hardcoded recipient fallback; keep environment access in configuration |
| `resources/views/layouts/app.blade.php` | Correct the recent Meta Lead bridge: demo-only targeting, stable event ID and repeat guard; retain prior independent loaders/fallbacks |
| `resources/views/requests/demo.blade.php` | Display warning/validation errors and retain rejected form values |
| `resources/views/requests/support.blade.php` | Display warnings from the shared controller without breaking support notifications |
| `tests/Feature/DemoRequestNotificationTest.php` | Add ten notification/validation/content/failure/tracking regression tests |
| `tests/Feature/ServiceRequestFormTest.php` | Use a configured test recipient and fake mail to avoid depending on the client address/transport |
| `tests/Feature/Admin/TrackingSettingsTest.php` | Fake mail for the existing submission test; check empty native Pixel behavior |
| `tests/Support/tracking-runtime.cjs` | Execute successful demo callbacks; verify targeted Lead, repeated callback, non-demo/no-ID suppression and external-Pixel ownership |
| `docs/tracking-integration-audit.md` | Link follow-up and clarify Disabled mode's Google-only event suppression |
| `docs/final-tracking-demo-audit.md` | Current report |

Earlier tracking changes still present in `app/Http/Requests/Admin/UpdateSiteSettingRequest.php` and `resources/views/admin/settings/edit.blade.php` were reviewed and retained; their reasons and tests are documented in the prior report. The existing Mailable, mail configuration and email template needed no code changes.

## Server administrator actions and readiness

1. Keep the client's existing `DEMO_REQUEST_RECIPIENT` for normal operation. Supply a real, approved transport through `MAIL_MAILER` and provider-specific host/port/credentials or service credentials. For SMTP, use the provider's required scheme/TLS settings; this Laravel configuration reads `MAIL_SCHEME`/`MAIL_URL`, not a `MAIL_ENCRYPTION` entry. Set an authenticated sender in `MAIL_FROM_ADDRESS`/`MAIL_FROM_NAME`.
2. Verify outbound provider access from the client server and its required sender/domain authentication, including SPF/DKIM/DMARC as applicable. Do not confuse email SPF with Google's separate Search Console verification TXT record.
3. Rebuild configuration after environment changes (`php artisan config:cache`), refresh compiled views after deployment and purge relevant public HTML caches. Do not cache personalized POST-result/session HTML. Verify external consent controls apply to native tags as well as GTM.
4. Repeat the actual form delivery test using the same process-only recipient override to `musab.m.alzoubii@gmail.com`, with an isolated/test request. Inspect provider acceptance evidence and have the test inbox owner confirm receipt/spam placement. Restore the original recipient and verify it afterward. No SMTP acceptance can be inferred from a successful Laravel log dispatch.
5. Complete tracking platform/DNS checks in the prior report. Native Meta Lead is demo-only; filter GTM conversion triggers appropriately and avoid equivalent native/GTM Lead or PageView tags. Google Ads fields still require external configuration rather than silently enabling paid conversions.
6. Resolve the unrelated stale public-route test before requiring an entirely green deployment pipeline. No missing public route was added speculatively.

### Explicit conclusions

1. **Is demo email functionality working?** Form validation, persistence, recipient resolution, Mailable rendering and notification dispatch work locally. Real delivery is blocked by this checkout's log-only transport and absent provider setup.
2. **Was a real test email successfully sent?** No SMTP email or inbox delivery is claimed. One actual non-faked dispatch completed through the configured log transport to the requested temporary recipient.
3. **What was fixed?** Untargeted/repeatable Meta Lead routing, hardcoded recipient fallback, missing recipient validation, raw exception logging, mail-failure success styling, and missing demo validation feedback/input retention.
4. **Does a successful demo trigger Meta Lead?** Yes in local source, Node execution and Chrome queue tests under all Google modes. It targets the native configured Pixel once for the stored demo event. Production Meta receipt remains unverified.
5. **Are production configuration changes required?** The client server's current mail setup is unknown. A real mail provider/authenticated sender is required wherever it is configured like this checkout. Tracking IDs, GTM ownership, consent, DNS and platform receipts must also be verified on the actual deployed domain.
6. **Ready to deploy?** The targeted code changes pass their checks and are ready for review/deployment. The system is **not yet verified for production email delivery or tracking receipt**; those acceptance checks and the unrelated suite error remain outstanding.
