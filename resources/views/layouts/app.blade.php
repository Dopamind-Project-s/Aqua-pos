<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    @php
        $gtmContainerId = $siteSetting?->gtm_container_id ?: config('services.gtm.container_id');
        $googleVerification = $siteSetting?->google_site_verification ?: config('services.google.site_verification');
        $clarityProjectId = $siteSetting?->ms_clarity_project_id ?: config('services.clarity.project_id');
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ app(\App\Support\DynamicContent::class)->get('global.seo.meta_title', $metaTitle ?? "Aqua POS") }}</title>
    <meta name="description" content="{{ app(\App\Support\DynamicContent::class)->get('global.seo.meta_description', $metaDescription ?? "Aqua POS cloud platform for POS, inventory, and business operations.") }}">
    @if($googleVerification)
        <meta name="google-site-verification" content="{{ $googleVerification }}">
    @endif

    @if($gtmContainerId)
        <!-- Google Tag Manager -->
        <script>
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: 'page_context',
                page_type: '{{ Route::currentRouteName() ?? 'unknown' }}',
                page_path: '{{ request()->path() }}',
            });
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $gtmContainerId }}');
        </script>
        <!-- End Google Tag Manager -->
    @endif

    <script>
        (function () {
            try {
                var savedTheme = localStorage.getItem('aqua_theme');
                if (savedTheme === 'dark') {
                    document.documentElement.style.colorScheme = 'dark';
                }
            } catch (error) {}
        })();
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Open+Sans:wght@400;500;600&family=Playfair+Display:wght@400;500;600&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet"> 

    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Theme Tokens -->
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

    <!-- Main Style -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
@if($gtmContainerId)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmContainerId }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
@endif

<script>
    (function () {
        try {
            if (localStorage.getItem('aqua_theme') === 'dark') {
                document.body.classList.add('dark-mode');
            }
        } catch (error) {}
    })();
</script>

@if($clarityProjectId)
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "{{ $clarityProjectId }}");
    </script>
@endif

@if(session('tracking_event'))
    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push(@json(session('tracking_event')));
    </script>
@endif

@include('partials.header')

@yield('content')

@include('partials.footer')

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

<script>
    window.AQUA_CMS_PAGE = @json($cmsSections ?? []);

    window.aquaApplyCmsPage = function () {
        const sections = window.AQUA_CMS_PAGE || {};
        const mode = document.body.classList.contains('dark-mode') ? 'dark' : 'light';

        document.querySelectorAll('[data-i18n]:not([data-cms-key])').forEach(function (el) {
            el.setAttribute('data-cms-key', el.getAttribute('data-i18n'));
        });

        const themed = function (value) {
            if (!value || typeof value !== 'object') {
                return value;
            }

            return mode === 'dark'
                ? (value.dark_value ?? value.light_value ?? null)
                : (value.light_value ?? value.dark_value ?? null);
        };

        const applyTextContent = function (el, data) {
            const locale = document.documentElement.getAttribute('lang') === 'ar' ? 'ar' : 'en';
            const value = data?.[locale] || data?.en || data?.ar;

            if (value) {
                el.textContent = value;
            }

            if (data?.style?.font_size) el.style.fontSize = data.style.font_size;
            if (data?.style?.line_height) el.style.lineHeight = data.style.line_height;
            if (data?.style?.text_align) el.style.textAlign = data.style.text_align;
            if (data?.style?.visible === false) el.style.display = 'none';
            if (data?.style?.text_color) el.style.color = themed(data.style.text_color);
            if (data?.style?.background_color === '__none__') {
                el.style.backgroundColor = 'transparent';
                el.style.backgroundImage = 'none';
            } else if (data?.style?.background_color) {
                el.style.backgroundColor = themed(data.style.background_color);
            }
        };

        Object.entries(sections).forEach(function ([sectionKey, section]) {
            const content = section.content || {};
            if (section.is_visible === false) {
                const sectionNode = document.querySelector('[data-cms-section="' + sectionKey + '"]');
                if (sectionNode) {
                    sectionNode.style.display = 'none';
                }
            }

            const sectionStyle = section.style?.__section || {};
            const sectionNode = document.querySelector('[data-cms-section="' + sectionKey + '"]');
            if (sectionNode) {
                if (sectionStyle?.background_color === '__none__' || sectionStyle?.background_image === '__none__') {
                    sectionNode.style.backgroundColor = 'transparent';
                    sectionNode.style.backgroundImage = 'none';
                    sectionNode.style.boxShadow = 'none';
                } else {
                    if (sectionStyle?.background_color) sectionNode.style.backgroundColor = themed(sectionStyle.background_color);
                    if (sectionStyle?.background_image) sectionNode.style.backgroundImage = 'url(' + sectionStyle.background_image + ')';
                    if (sectionStyle?.overlay) sectionNode.style.boxShadow = 'inset 0 0 0 9999px ' + sectionStyle.overlay;
                }
            }

            Object.keys(content).forEach(function (key) {
                const data = content[key];
                const style = section.style?.[key] || data?.style || {};

                const scope = sectionNode || document;

                scope.querySelectorAll('[data-cms-key=\"' + key + '\"]').forEach(function (el) {
                    if (el.tagName === 'IMG' && (data?.src || data?.url || typeof data === 'string')) {
                        el.src = data?.src || data?.url || data;
                        if (style?.width) el.style.width = style.width;
                        if (style?.height) el.style.height = style.height;
                    } else if (data?.type === 'text') {
                        applyTextContent(el, { ...data, style: style });
                    } else if (data?.type === 'button') {
                        const locale = document.documentElement.getAttribute('lang') === 'ar' ? 'ar' : 'en';
                        el.textContent = data?.[locale] || data?.en || data?.ar || el.textContent;
                        if (data?.link) el.setAttribute('href', data.link);
                        if (style?.background_color) el.style.backgroundColor = themed(style.background_color);
                        if (style?.text_color) el.style.color = themed(style.text_color);
                        if (style?.border_color) el.style.borderColor = themed(style.border_color);
                    } else if (data?.type === 'icon') {
                        if (data?.value) el.className = data.value;
                        if (style?.color) el.style.color = themed(style.color);
                        if (style?.size) el.style.fontSize = style.size;
                    } else if (typeof data === 'string' && el.tagName === 'I') {
                        el.className = data;
                    }
                });
            });
        });
    };

    window.aquaApplyCmsPage();
</script>

<script src="{{ asset('js/main.js') }}"></script>

@stack('scripts')

@include('partials.cms-editor')

</body>
</html>
