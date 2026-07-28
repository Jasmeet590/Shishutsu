<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shishutsu') }} | Login</title>

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
                    <p class="brand-copy">Manage parties, GST bills, invoices, and daily billing work from one focused workspace.</p>
                </div>
                <div class="brand-foot">Secure access for your billing dashboard</div>
            </aside>

            <section class="login-panel">
                <div class="login-form-wrap">
                    <h2 class="login-heading">{{ __('Welcome back') }}</h2>
                    <p class="login-subtitle">{{ __('Sign in to continue to your dashboard.') }}</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="name@example.com">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password" placeholder="Enter your password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="login-options">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember me') }}
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a class="forgot-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-login">
                            {{ __('Login') }}
                        </button>
                    </form>
                </div>
            </section>
        </section>
    </main>
</body>

</html>
