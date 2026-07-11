@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <div class="auth-card">

        <img src="{{ asset('img/logo.png') }}" class="logo" alt="Logo">

        <h2 class="auth-title">
            Selamat Datang
        </h2>

        <p class="auth-subtitle">
            Silakan login untuk mengakses SIMHP
        </p>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">

            @csrf

            <!-- Email -->
            <div class="mb-4">

                <label class="form-label">
                    Email
                </label>

                <div class="input-group">

                    <i class="bi bi-envelope"></i>

                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email" required
                        autofocus>

                </div>

                @error('email')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <!-- Password -->
            <div class="mb-4">

                <label class="form-label">Password</label>

                <div class="input-wrapper">

                    <i class="bi bi-lock input-icon"></i>

                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Masukkan password">

                    <button type="button" id="togglePassword" class="password-toggle">

                        <i class="bi bi-eye"></i>

                    </button>

                </div>

            </div>

            

            <button type="submit" class="btn btn-login w-100">

                <i class="bi bi-box-arrow-in-right me-2"></i>

                Masuk

            </button>

        </form>

        <hr class="my-4">

        <div class="text-center text-muted">

            SIMHP Versi 1.0

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        const toggle = document.getElementById('togglePassword');

        const password = document.getElementById('password');

        toggle.addEventListener('click', function() {

            if (password.type === 'password') {

                password.type = 'text';

                this.innerHTML = '<i class="bi bi-eye-slash"></i>';

            } else {

                password.type = 'password';

                this.innerHTML = '<i class="bi bi-eye"></i>';

            }

        });
    </script>
@endpush
