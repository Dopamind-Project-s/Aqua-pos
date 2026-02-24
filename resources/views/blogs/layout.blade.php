<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua POS | {{ ucfirst($type ?? 'blog') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .blogs-shell { background: #f5f7fb; min-height: 100vh; }
        .blogs-nav { background: #0c1d3a; }
        .blogs-nav .nav-link, .blogs-nav .navbar-brand { color: #fff !important; }
        .blog-hero { background: linear-gradient(120deg, #0c1d3a, #1166b7); color: #fff; padding: 64px 0 52px; }
        .blog-card { border: 0; border-radius: 18px; overflow: hidden; box-shadow: 0 10px 24px rgba(16, 30, 54, .08); }
        .blog-card .thumb { width:100%; height:220px; object-fit:cover; }
        .blog-card .meta { font-size: 13px; color:#667085; }
        .blog-sidebar-card { background:#fff; border-radius:18px; padding:20px; box-shadow: 0 10px 24px rgba(16,30,54,.06); }
        .badge-soft { background:#e8f1ff; color:#0d4f99; border-radius:20px; padding:6px 12px; font-size:12px; }
        .article-shell { background:#fff; border-radius:20px; padding:28px; box-shadow: 0 10px 24px rgba(16,30,54,.06); }
        .article-content { line-height: 1.9; color:#1d2939; }
    </style>

    @stack('styles')
</head>
<body class="blogs-shell">
@include('blogs.partials.navbar')
@yield('content')
@include('partials.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
