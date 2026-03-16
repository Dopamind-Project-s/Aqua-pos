<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-2">Admin Login</h1>
        <p class="text-sm text-gray-600 mb-6">Sign in to access the admin dashboard.</p>

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-50 text-red-700 px-4 py-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" name="password" type="password" required
                       class="w-full rounded border border-gray-300 px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="remember" value="1" class="rounded border-gray-300">
                Remember me
            </label>

            <button type="submit"
                    class="w-full rounded bg-blue-600 text-white font-semibold px-4 py-2 hover:bg-blue-700 transition-colors">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
