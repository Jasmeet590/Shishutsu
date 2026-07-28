<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shishutsu') }} | Register</title>

    <link href="{{ asset('assets/css2/bootstrap-creative.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css2/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/auth-login.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <main class="login-page">
        <section class="login-shell">
            <aside class="login-brand">
                <div>
                    <div class="brand-mark">S</div>
                    <h1 class="brand-title">Shishutsu</h1>
                    <p class="brand-copy">Create your account to manage parties, GST bills, invoices, and daily billing work.</p>
                </div>
                <div class="brand-foot">Secure access for your billing dashboard</div>
            </aside>

            <section class="login-panel">
                <div class="login-form-wrap">
                    <h2 class="login-heading">{{ __('Create account') }}</h2>
                    <p class="login-subtitle">{{ __('Set up your access to continue to the dashboard.') }}</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                placeholder="Enter your name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                placeholder="name@example.com">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" placeholder="Create a password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm your password">
                        </div>

                        <button type="submit" class="btn btn-login">
                            {{ __('Register') }}
                        </button>

                        @if (Route::has('login'))
                            <p class="auth-switch">
                                {{ __('Already have an account?') }}
                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </p>
                        @endif
                    </form>
                </div>
            </section>
        </section>
    </main>
</body>

</html>
