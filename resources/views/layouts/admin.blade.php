<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua POS Admin</title>

    <link href="{{ asset('dashboard/assets/css/styles.min.css') }}" rel="stylesheet">
</head>

<body>

@yield('content')

<script src="{{ asset('dashboard/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/app.min.js') }}"></script>

@stack('scripts')

</body>
</html>