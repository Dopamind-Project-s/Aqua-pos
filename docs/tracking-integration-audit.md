# Tracking integrations audit

Audit date: 7 November 2026. Scope: this Laravel 12 repository and isolated local execution. Changes below are local source changes, not a deployment.

Follow-up: [Final tracking and demo email audit](final-tracking-demo-audit.md) covers the subsequent Meta Lead bridge fixes, notification audit, actual configured-transport dispatch test and updated test totals. This document retains the earlier audit evidence.

Latest status: [production readiness](production-readiness.md) resolves the unrelated stale route test; all 57 tests now pass. SMTP delivery still requires administrator configuration and verification.

## 1. Integration status

| Integration | Code status | Configuration status | Production verification | Root cause |
|---|---|---|---|---|
| Google Analytics 4 | Direct loader and config are correct; exclusive with GTM; tests pass | Actual client ID/property not inspected; client's success report is not independent evidence | Not observed | **E** for production; no confirmed GA4 code defect |
| Google Tag Manager | Standard head bootstrap and body noscript; direct GA4 excluded | Container publication, tags, triggers and consent settings not accessible | Not observed | **E**; downstream tags remain external configuration |
| Google Search Console | Initial HTML head meta tag supported independently; token validation improved | Client token/property/domain not inspected | Reported DNS TXT failure; DNS not queried without a confirmed domain | **D**, based on supplied error description; precise DNS cause **E**. Input validation weakness **A**, fixed |
| Meta Pixel | Missing implementation **fixed**: bootstrap, initialization, targeted PageView and body noscript | Client Pixel ID/account and any GTM Pixel tags not inspected | No real Meta requests or Events Manager receipt observed | **A** confirmed before fix; remaining configuration/production status **E** |
| Google Ads | Fields persist but are not consumed by frontend; no native Ads loader or conversion call | Existing roadmap delegates Ads conversion setup to GTM; published setup unknown | Not observed | **A** if native tracking from these fields is expected; **D/E** for GTM conversion configuration |
| Microsoft Clarity | Existing independent loader; ID validation and JS serialization improved; moved to head | Actual project and external consent/project settings not inspected | No live collection or dashboard receipt observed | **A** input/serialization weakness fixed; no demonstrated production failure; remaining status **E** |

Categories: **A** Application Code Issue; **B** Admin Configuration Issue; **C** Server / Hosting Issue; **D** External Platform / DNS Issue; **E** Not Yet Verified. No specific client-side **B** or hosting **C** failure was established. Unknowns must not be interpreted as success.

## 2. Implementation trace and evidence

### Settings → persistence → public HTML

1. `routes/web.php`: `GET /admin/settings` and `PUT /admin/settings` require both `auth` and `admin`. Public homepage and content routes do not require authentication. CSRF protection remains in the web middleware and form.
2. `resources/views/admin/settings/edit.blade.php`: all eight fields exist. The selector uses `none`, `ga4`, `gtm`. Inactive Google ID inputs remain submitted, retaining IDs when switching methods; JavaScript uses `aria-disabled`, not disabled form controls.
3. `app/Http/Requests/Admin/UpdateSiteSettingRequest.php:10`: Google IDs are trimmed and uppercased; the selected method requires its corresponding ID. Other fields use Laravel's normal string trimming/null conversion. New rules reject full snippets in the Pixel, HTML verification and Clarity ID fields.
4. `app/Http/Controllers/Admin/SiteSettingController.php:14` and `:57`: loads/creates setting ID 1 and updates validated fields. `app/Models/SiteSetting.php:24` allows all tracking fields to be persisted. Tracking columns are nullable strings from `database/migrations/2026_03_19_000500_add_tracking_fields_to_site_settings.php`; no schema change was necessary.
5. `app/Providers/AppServiceProvider.php:27`: the global view composer reads `SiteSetting::first()` from the database and supplies `$siteSetting`. Tracking settings are not cached in an application singleton or Cache store. The architecture assumes one general settings row; writes target ID 1 and reads use the first row. No evidence of conflicting client rows was available, so no speculative persistence refactor was made.
6. `resources/views/layouts/app.blade.php:5`: resolves settings and environment fallbacks. The homepage and public content templates extend this layout; blog detail/list templates inherit it through `resources/views/blogs/layout.blade.php`. Header/footer contain no additional static tracking bootstraps.
7. Rendered inline code queues events; asynchronous third-party libraries must subsequently load and transmit them. Provider dashboards must independently confirm receipt.

### GA4 and GTM

`resources/views/layouts/app.blade.php:61` emits `https://www.googletagmanager.com/gtag/js?id=G-…`, defines `window.gtag`, then queues `js` and `config` with the configured measurement ID. `@json` serializes the ID. The `elseif` at line 70 selects GTM instead, and its matching body iframe uses `ns.html?id=GTM-…` immediately after the opening body when enabled.

`none` loads neither Google runtime and suppresses Google event routing. Independent native Meta tracking remains enabled when configured, including the subsequent demo Lead bridge described in the follow-up report. Legacy null/unknown method values fall back to GTM if a container is available, preserving existing behavior. The tracking-method migration explicitly migrated historical saved GTM IDs to `gtm`.

The application does not explicitly emit `page_view`; normal direct GA4 configuration provides the automatic page view. `page_context` is a separate custom event. Mode switching cannot render both native GA4 and GTM in a single server response. A previously opened tab continues running its original scripts until navigation/reload.

`app/Http/Controllers/ServiceRequestController.php` flashes `generate_lead` only after successfully saving a request; the layout consumes it through the central tracker. Existing public JavaScript also routes interaction events through that helper. No second static GA4 loader was found. Duplicate GA4 tags, page-view triggers or Meta tags inside a published GTM container cannot be excluded without inspecting that container.

Local format/status indicators describe activation/configuration, not provider connectivity. The settings page already warns that its check does not prove Google received data; the dashboard's “Active” label likewise derives only from method/ID format (`app/Http/Controllers/Admin/DashboardController.php:51`).

### Search Console

`resources/views/layouts/app.blade.php:36` renders exactly one conditional `<meta name="google-site-verification" content="…">` in the initial server-rendered head, including on anonymous homepage requests. It does not depend on GA4/GTM or JavaScript. Blade escapes attribute content correctly; a valid token consisting of letters, numbers, `_` and `-` is unchanged.

Previously the field accepted any string, including a complete HTML tag or `google-site-verification=…` DNS record, and would place that entire value into `content`. That is a confirmed validation gap, but there is no evidence the client entered either. New saves require the content token alone; existing malformed values must be corrected by an administrator. They remain escaped safely rather than silently rewritten.

`search_console_property` is saved separately and is not rendered as a verification token. It is a reference field, not a Search Console API integration or ownership-verification action.

The described error says Google looked for DNS TXT verification and found an SPF record. It supports a missing/unavailable expected TXT value at verification time; it does **not** establish why. Possibilities include a missing record, wrong DNS zone/host, editing a non-authoritative provider, wrong token/domain, or propagation. An SPF TXT record may coexist with a separate Google TXT record and must not be replaced.

A Domain Property requires domain-provider verification. An HTML tag is available for an appropriate URL-prefix property and cannot replace a Domain Property DNS record. See [Google's ownership verification documentation](https://support.google.com/webmasters/answer/9008080).

### Meta Pixel

Before this change, `meta_pixel_id` appeared in model, schema, request and admin input only. There was no `fbq`, `fbevents.js`, Pixel initialization, PageView or noscript image in application/public source. Saving a correct ID could not produce a native Pixel event. This is a confirmed code explanation for native integration failure; an externally configured GTM Pixel is a separate possibility.

The fix at `resources/views/layouts/app.blade.php:82` installs the standard queue/bootstrap loading `https://connect.facebook.net/en_US/fbevents.js`, preserves an existing `fbq`, initializes the configured numeric ID and queues PageView. It uses `fbq('trackSingle', PIXEL_ID, 'PageView')` rather than the broadcast `fbq('track', 'PageView')`, targeting only the configured Pixel when other Pixels exist. The body noscript image requests `https://www.facebook.com/tr?id=…&ev=PageView&noscript=1` only when JavaScript is disabled.

An application-owned initialization map prevents this application's repeated bootstrap from initializing the same Pixel or queuing PageView twice. It cannot deduplicate a separately managed GTM Pixel initialization/event, especially one running asynchronously. Choose one owner: populate the native field and remove the equivalent GTM tag, or leave the native field empty when GTM owns that Pixel. Do the same for Clarity and its environment fallback.

No other repository code overwrites `fbq`. Meta Pixel Helper and Meta Events Manager were not available through an authenticated client account. The [official Meta setup page](https://developers.facebook.com/docs/meta-pixel/get-started/) returned HTTP 429 during documentation retrieval; no external Meta receipt is asserted.

### Google Ads and Clarity

Google Ads ID and label are accepted and persisted but neither is read by frontend code. There is no native `AW-…` config or `conversion` event. The pre-existing `docs/marketing-tracking-roadmap-ar.md` explicitly lists GTM Conversion Linker, Ads conversion actions and triggers as pending platform work. This audit preserves that architecture and makes the storage-only behavior explicit beside the fields.

No speculative conversion trigger was added: the application currently labels support, contact and demo submissions as `generate_lead`; counting all of them as paid conversions without a defined conversion action would change campaign measurement. To use Ads now, configure a published GTM Ads conversion tag and approved trigger, or import an intentionally selected GA4 key event. Native Ads support would require a separate agreed conversion mapping and tested implementation; the stored fields alone do nothing. Google's documentation distinguishes a configured tag from the conversion event and destination: [conversion measurement](https://developers.google.com/tag-platform/devguides/conversions).

Clarity was already independent of the Google selector, but accepted arbitrary strings and interpolated the ID with HTML escaping inside a JavaScript string. That could produce a wrong URL or JS escape interpretation for malformed stored values. It now validates alphanumeric IDs, checks existing database/environment values before loading and uses `@json`. The bootstrap is in the head as recommended by [Microsoft's setup documentation](https://learn.microsoft.com/en-us/clarity/setup-and-installation/clarity-setup). No Clarity code is gated behind GA4/GTM.

## 3. Deployment, cache, security and consent findings

- `config/services.php` supplies `GTM_CONTAINER_ID`, `GOOGLE_SITE_VERIFICATION`, `MS_CLARITY_PROJECT_ID`. Database nonempty values win. Clearing a database field restores its environment fallback; clear both sources when disabling an independently configured integration. GA4 and Pixel currently have no environment fallback. `none` still suppresses GTM even if the environment contains a GTM ID.
- `.env.example` documents those three fallbacks. Actual client production values, server environment and database have not been inspected. No credentials or production values were changed.
- Settings are queried afresh; tests confirm changed IDs/tokens appear in subsequent responses. `app/Support/DynamicContent.php` caches CMS content, not the tracking settings. Laravel compiled views cache PHP templates, not resolved database IDs. Laravel configuration caching can retain old environment fallbacks until configuration is rebuilt.
- No application response-page cache package/middleware, tracking consent manager, Consent Mode setup, Meta consent API, CSP header middleware or CSP meta tag was found. `bootstrap/app.php` adds locale middleware and auth/admin aliases. The locale cookie is not tracking consent. Scripts therefore load when configured, subject to any external CMP/GTM controls.
- No application's consent behavior was removed or bypassed. An external CMP that controls only GTM will not automatically control newly configured native Meta or existing native Clarity/GA4; the client must verify its deployed consent arrangement and keep tag ownership consistent. No speculative CMP implementation was introduced.
- Neither checked-in `.htaccess` enforces HTTPS or a chosen www/non-www host. No application canonical link or explicit trusted-proxy configuration was found. These are deployment checks, not evidence that production redirects or HTTPS are wrong. `APP_URL` alone does not enforce incoming-host redirects. Do not guess the canonical domain from a source checkout.
- The repository-root `.htaccess` rewrites requests into `public/`; production should point the virtual host document root directly at `public/`. It also contains duplicate rewrite entries. No rewrite changes were made without evidence of the client's vhost configuration or a tracking-related redirect failure.
- Proxy/CDN HTML caches, web-server CSP, injected scripts, firewalls and browser blockers cannot be established from source. Inspect actual response headers and browser errors before changing security policy. Do not remove CSP to make tracking work; authorize only required script/connect/image/frame destinations, retaining nonces/hashes where used.
- Public content pages use the shared layout. The admin login also extends it, while the authenticated admin layout does not. Tracking is therefore not restricted to authenticated/admin pages. No SPA/router page-view mechanism was found; ordinary full-page navigation reruns the layout.

## 4. Changes applied

| File | Change and reason | Verification |
|---|---|---|
| `resources/views/layouts/app.blade.php` | Add independent Meta bootstrap, targeted PageView, repeat guard and noscript image; validate legacy Pixel/Clarity IDs; serialize Clarity with JSON and move it to head | Public-response tests, Node execution tests, isolated Chrome execution |
| `app/Http/Requests/Admin/UpdateSiteSettingRequest.php` | Reject script snippets/non-numeric Pixel IDs, full tags/DNS strings in HTML token field and malformed Clarity IDs; actionable validation messages | Admin save/rejection and rendering tests; Pint |
| `resources/views/admin/settings/edit.blade.php` | Clarify Google-only Disabled selection, token/DNS distinction, GTM duplicate ownership and storage-only Ads fields | Source review; existing layout and fields preserved |
| `tests/Feature/Admin/TrackingSettingsTest.php` | Add independent-mode/page rendering, persistence/update, environment precedence, invalid legacy value, validation and JS execution regressions; correct an existing assertion to match JSON's escaped slash | 16 tests, 289 assertions pass |
| `tests/Support/tracking-runtime.cjs` | Execute actual rendered inline tracking scripts with stub DOM; check queues, Google exclusivity, repeat Meta guard and helper routing | Invoked by PHPUnit; all three modes pass |
| `docs/tracking-integration-audit.md` | Findings, limits, remediation and operational verification | This report |

No schema, DNS, account, production credential or deployed-server changes were made.

### Tests and evidence limits

The normal initial test command stopped with `could not find driver` before making assertions because the installed CLI PHP lacks PDO SQLite. A matching Ubuntu PHP SQLite package was downloaded and extracted only into `/tmp/aqua-tracking-php`; its `pdo_sqlite.so` was loaded for individual test processes. Nothing was installed system-wide.

Reproduce with a normally installed PDO SQLite extension:

```bash
php vendor/bin/phpunit --filter TrackingSettingsTest
vendor/bin/pint --test app/Http/Requests/Admin/UpdateSiteSettingRequest.php tests/Feature/Admin/TrackingSettingsTest.php
git diff --check
```

Actual isolated command:

```bash
php -d extension=/tmp/aqua-tracking-php/extracted/usr/lib/php/20230831/pdo_sqlite.so vendor/bin/phpunit --filter TrackingSettingsTest
```

Public anonymous requests covered `/`, `/about`, `/blog`, `/news`, `/products`, `/contact`, `/support` under `none`, `ga4`, `gtm`. Other content templates were traced through shared-layout inheritance; data-dependent detail pages were not individually browser-tested.

Headless Chrome ran an isolated server-rendered `/about` response backed by an in-memory database, with external hostname resolution blocked. Observed: method `ga4`; one `config`; Meta queue `[init, test ID]` and `[trackSingle, test ID, PageView]`; verification token `browser_token`; one Clarity script insertion. This proves local inline execution/DOM behavior, not download or execution of third-party SDKs. Node additionally exercised all modes and reexecuted the Meta bootstrap to check its guard.

The final broader suite ran 47 tests with 380 assertions: 46 passed and one errored because `tests/Feature/PublicRoutesTest.php:13` requests nonexistent route `service`; it also references other removed legacy routes. The tracking changes do not modify routes. This unrelated test was not rewritten as part of tracking repair. Final targeted tests and formatting/whitespace checks pass.

Evidence levels remain separate: **format accepted → HTML rendered → local JS executed → remote library loaded → event transmitted → provider received event**. This audit verifies the first three locally. It does not claim the final three for production.

## 5. Client / hosting administrator checklist

### Deploy and establish one source of tags

1. Deploy the reviewed source changes through the client's normal process. Existing tracking migrations must already be applied; this patch adds none. Confirm `/admin/settings` saves against the database used by the public site.
2. Confirm the authoritative production hostname and HTTPS URL, correct TLS, virtual-host document root `public/`, proxy HTTPS forwarding and appropriate trusted proxy settings. In production use `APP_ENV=production`, `APP_DEBUG=false` and the correct `APP_URL`.
3. Rebuild configuration after changing environment fallbacks with `php artisan config:cache`; rebuild changed compiled templates with `php artisan view:clear` followed by `php artisan view:cache` if used in deployment. Restart persistent app workers if the hosting stack keeps application/configuration state. Do not indiscriminately clear unrelated application data caches.
4. Purge the hosting/CDN **HTML page cache** for public pages. Verify the returned source contains current IDs/tokens. A browser hard reload alone cannot invalidate CDN HTML.
5. Choose GA4 Direct or GTM. In GTM, inspect and publish the intended Google tag and triggers. Do not configure an extra automatic GA4 page view for the same page.
6. Choose native or GTM ownership separately for Meta and Clarity. When using native Meta, remove/pause the same Pixel initialization/PageView in GTM before enabling the native ID. When GTM owns it, leave the native field empty. Clear `MS_CLARITY_PROJECT_ID` as well if GTM owns Clarity. Verify the deployed CMP governs the chosen paths.

### GA4 Realtime verification — requires GA4 property access

1. Select the correct web data stream and copy its `G-…` ID. Save it with GA4 Direct, or use GTM with the published Google tag targeting that stream.
2. Open an anonymous browser session on the confirmed public URL, with consent granted where required and extensions disabled for the test. Use Google Tag Assistant when needed for debugging.
3. In DevTools, confirm `gtag/js?id=G-…` for direct mode, or `gtm.js?id=GTM-…` for GTM. Check collection requests for the correct measurement ID and event names. Script status 200 alone is insufficient.
4. Open GA4 Realtime for that property and confirm your visit/page activity. For event details use DebugView with an actual debug-enabled session. Submit a test form once and check `generate_lead`; protect real contact details from event payloads.
5. Check that each full navigation produces the intended single page view. Account filters, consent and reporting delays may affect visibility; inspect them before declaring failure or success.

### Search Console DNS TXT verification — requires DNS and Search Console access

1. Open the intended **Domain Property** and copy the exact TXT record value supplied by its verification screen, typically `google-site-verification=TOKEN`.
2. Identify the domain's authoritative nameservers. Edit the DNS zone actually served by those nameservers, which may differ from the web host.
3. Add a **new TXT record** at the domain/host shown by Google. For an apex zone this is often `@` or blank, according to the provider. Do not insert it into the SPF record or delete/replace SPF. Avoid accidentally creating `example.com.example.com` in providers that append the zone.
4. Check authoritative and public answers, substituting the real domain and nameserver:

   ```bash
   dig NS example.com +short
   dig TXT example.com @authoritative.nameserver.example +short
   dig TXT example.com @8.8.8.8 +short
   dig TXT example.com @1.1.1.1 +short
   ```

5. Confirm the exact token is returned; allow provider publication and resolver TTL/negative-cache propagation, then retry Verify. If authoritative answers lack it, fix the zone/host/value before waiting. Keep the record after verification. No application code can publish this DNS record.

### Search Console HTML meta verification — requires URL-prefix property access

1. Select/add a **URL-prefix Property** matching the intended protocol, hostname and path; use its **HTML tag** verification method.
2. Copy only the supplied tag's `content` value into **Google Site Verification**. Do not paste `<meta …>`, `google-site-verification=…` or `sc-domain:…`. Search Console Property can hold the property reference but does not verify ownership.
3. Save, clear relevant HTML/config caches and open the anonymous homepage's **View Source**. Confirm exactly one matching tag inside `<head>` in the initial response.
4. Follow the real redirect chain and ensure Google reaches the intended public homepage without login, bot challenge or an unrelated domain. Check www/non-www and HTTPS behavior against Google's property/method requirements. A canonical link alone does not perform verification or redirect a request.
5. Click Verify and retain the token. This method does not satisfy a separate Domain Property DNS check.

### Meta Events Manager and Pixel Helper — requires Meta dataset/Pixel access

1. Confirm the numeric Pixel/dataset ID in Events Manager and the intended account/domain. Save only that ID, choosing one native/GTM owner.
2. Open Events Manager → the relevant data source → **Test Events**. Launch/visit the public site in the intended test session. Install/use Meta Pixel Helper on the browser if available.
3. Confirm one detected configured Pixel and PageView per full navigation, no duplicate initialization and no helper errors. Visit several public routes anonymously.
4. Verify the matching PageView actually appears in Test Events. Inspect account traffic permissions, domain settings, diagnostics and consent settings if it does not. Helper detection or a queued function call is not receipt.
5. If testing with JavaScript disabled, inspect the noscript `facebook.com/tr` image request separately. Do not expect a working JavaScript helper in that scenario.

### Browser DevTools Network — public URL required

1. Open Network, enable Preserve log and disable browser cache for the test. Reload anonymously after granting any applicable consent. Inspect Console for syntax/runtime errors, CSP violations and blocked requests.
2. Check scripts: `googletagmanager.com/gtag/js` or `/gtm.js`, `connect.facebook.net/en_US/fbevents.js`, `clarity.ms/tag/PROJECT_ID`. Check expected IDs and avoid duplicate loaders.
3. Check events: Google Analytics `g/collect` (including regional hosts where used); Meta `facebook.com/tr` with the intended `id` and `ev=PageView`; Clarity collection requests. SDK routing can vary; inspect the actual initiator and payload.
4. Distinguish DNS/network errors, `ERR_BLOCKED_BY_CLIENT`, CSP refusal, consent suppression and HTTP errors. Preserve a sanitized HAR if diagnosis is needed; collection request success still needs provider-side receipt confirmation.
5. Inspect the homepage document's response headers for CSP, redirects and cache headers (`Age`, `Via`, provider cache status). Compare returned initial source with current admin values. Inspect script-src/connect-src/img-src/frame-src restrictions without weakening unrelated policies.

### Google Ads and Clarity completion

For Ads, define the actual conversion action and approved event first. If retaining GTM, configure the Google tag/Conversion Linker and Ads Conversion Tracking tag with the account's ID/label. A Custom Event trigger can use `generate_lead` and filter `form_type` to the approved form; use GTM Preview to validate success/failure paths and one firing. Publish after review. In GA4 Direct mode, consider an explicitly configured GA4 key-event import instead; saved native Ads fields do not implement it. Confirm the action in Google Ads diagnostics. Do not assume a page visit is a paid conversion.

For Clarity, confirm the project ID, one loader, collection requests and recordings/dashboard activity in the intended project. Validate the project's consent configuration and any external CMP. Microsoft describes both collection-request inspection and dashboard checks in its [installation verification instructions](https://learn.microsoft.com/en-us/clarity/setup-and-installation/clarity-setup).

## 6. Explicit conclusions

1. **Is GA4 implemented correctly?** Yes at the source/rendered-script/local execution level: correct direct loader and configuration, exclusive with native GTM. Production loading, collection and account receipt remain unverified.
2. **Is Search Console implemented correctly?** HTML token verification is correctly rendered independently in the initial public head; input validation is now clearer/stricter. Domain verification remains DNS work. The reported TXT error cannot be fixed by adding a meta tag.
3. **Is Meta Pixel implemented correctly?** It was missing despite saved settings. The native implementation is now present and locally tested. Deployment, third-party loading, GTM duplicate checks and Events Manager receipt remain outstanding.
4. **What required code fixes were applied?** Missing Meta runtime/fallback; Pixel/token/Clarity input validation; Clarity JS serialization and head placement; admin wording explaining independent integrations and Ads limitations; regression tests. No speculative conversion mapping or DNS manipulation was introduced.
5. **What must the client/host fix?** Publish the correct DNS verification record for Domain Property verification; deploy this patch and review IDs/tokens; choose one owner for each tag; configure/publish GTM Ads conversions where desired; validate redirects/HTTPS, deployed caches/CSP and consent paths; confirm events in the correct accounts. Specific hosting faults are not established.
6. **What still requires production verification?** All six integrations. A confirmed public URL and deployment observation are needed for HTML/headers/network checks; authenticated GA4, GTM, Search Console, Ads, Meta and Clarity access is needed for platform configuration and receipt. DNS-provider access is needed to repair TXT records. None of those external systems was modified.
