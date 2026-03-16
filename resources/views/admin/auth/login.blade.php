@extends('layouts.app')

@php
    $metaTitle = 'Admin Login | ' . (($siteSetting ?? null)?->site_name ?? 'AQUA POS');
    $metaDescription = 'Admin access page for ' . (($siteSetting ?? null)?->site_name ?? 'AQUA POS') . ' dashboard.';
@endphp

@section('content')
<div class="container-fluid py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card border-0 shadow-sm">
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
            </div>
        </div>
    </div>
</div>
@endsection
