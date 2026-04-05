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

    <title>{{ dynamic_content('global.seo.meta_title', $metaTitle ?? "Aqua POS") }}</title>
    <meta name="description" content="{{ dynamic_content('global.seo.meta_description', $metaDescription ?? "Aqua POS cloud platform for POS, inventory, and business operations.") }}">
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

    (function () {
        const sections = window.AQUA_CMS_PAGE || {};

        const applyTextContent = function (el, data) {
            const locale = document.documentElement.getAttribute('lang') === 'ar' ? 'ar' : 'en';
            const value = data?.[locale] || data?.en || data?.ar;

            if (value) {
                el.textContent = value;
            }

            if (data?.style?.font_size) el.style.fontSize = data.style.font_size;
            if (data?.style?.text_color) el.style.color = data.style.text_color;
        };

        Object.values(sections).forEach(function (section) {
            const content = section.content || {};

            Object.keys(content).forEach(function (key) {
                const data = content[key];

                document.querySelectorAll('[data-i18n=\"' + key + '\"]').forEach(function (el) {
                    if (data?.type === 'text') {
                        applyTextContent(el, data);
                    }
                });

                document.querySelectorAll('[data-cms-key=\"' + key + '\"]').forEach(function (el) {
                    if (el.tagName === 'IMG' && data?.url) {
                        el.src = data.url;
                    } else if (data?.type === 'text') {
                        applyTextContent(el, data);
                    }
                });
            });
        });
    })();
</script>

<script src="{{ asset('js/main.js') }}"></script>

@stack('scripts')

@include('partials.cms-editor')

</body>
</html>
