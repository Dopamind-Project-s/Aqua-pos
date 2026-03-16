<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="{{ asset('dashboard/assets/css/styles.min.css') }}" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: #f5f7fb;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: 0;
            box-shadow: 0 12px 40px rgba(27, 57, 108, .08);
        }
    </style>
</head>
<body>
<div class="card login-card">
    <div class="card-body p-4 p-md-5">
        <h1 class="h4 mb-1">Admin Login</h1>
        <p class="text-muted mb-4">Sign in to access the admin dashboard.</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="form-control">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password" required class="form-control">
            </div>

            <div class="form-check mb-4">
                <input type="checkbox" name="remember" value="1" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
    </div>
</div>
</body>
</html>
