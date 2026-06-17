@extends('layouts.auth')

@section('title', 'Login Staff')

@section('content')
<main class="auth-shell">
    <section class="auth-card" aria-labelledby="login-title">
        <a href="{{ route('home') }}" class="auth-brand" aria-label="Kembali ke website Anita Konveksi">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Anita Konveksi">
            <span>
                <strong>Anita Konveksi</strong>
                <small>Panel Staff</small>
            </span>
        </a>

        <div class="auth-heading">
            <p class="auth-eyebrow">AKSES INTERNAL</p>
            <h1 id="login-title">Login Staff</h1>
            <p>Masukkan akun owner atau admin untuk melanjutkan.</p>
        </div>

        <form method="POST" action="{{ route('login.attempt') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    id="username"
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    autofocus
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <label class="remember-option">
                <input type="checkbox" name="remember" value="1">
                <span>Ingat saya di perangkat ini</span>
            </label>

            @if ($errors->any())
                <div class="auth-error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="auth-submit">Masuk</button>
        </form>

        <a href="{{ route('home') }}" class="back-link">&larr; Kembali ke website utama</a>
    </section>
</main>
@endsection
