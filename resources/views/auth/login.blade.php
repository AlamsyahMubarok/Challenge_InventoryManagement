<x-guest-layout>
    @include('auth.partials.auth-responsive-style')

    <style>
        @media (min-width: 1025px) {
            html,
            body {
                height: 100%;
                overflow: hidden;
            }

            .auth-page-login {
                height: 100svh;
                min-height: 100svh;
                overflow: hidden;
            }

            .auth-page-login .auth-illustration {
                height: 100svh;
                min-height: 100svh;
                overflow: hidden;
            }

            .auth-page-login .auth-illustration img {
                width: 100%;
                height: 100%;
                min-height: 100%;
                object-fit: cover;
                object-position: center center;
                display: block;
            }

            .auth-page-login .auth-content {
                height: 100svh;
                min-height: 100svh;
                overflow: hidden;
                padding-top: 22px;
                padding-bottom: 22px;
            }

            .auth-page-login .auth-form-wrap {
                margin-block: auto;
            }

            .auth-page-login .auth-logo {
                width: 190px;
                margin-bottom: 6px;
            }

            .auth-page-login .auth-subtitle {
                margin-bottom: 26px;
                font-size: 13px;
                line-height: 1.5;
            }

            .auth-page-login .auth-title {
                font-size: 32px;
                margin-bottom: 10px;
            }

            .auth-page-login .auth-description {
                margin-bottom: 24px;
                font-size: 14px;
                line-height: 1.6;
            }

            .auth-page-login .form-group {
                margin-bottom: 16px;
            }

            .auth-page-login .form-label {
                margin-bottom: 7px;
                font-size: 13px;
            }

            .auth-page-login .form-input {
                height: 50px;
                border-radius: 16px;
                font-size: 14px;
            }

            .auth-page-login .form-input::placeholder {
                font-size: 13px;
            }

            .auth-page-login .password-box .form-input {
                padding-right: 92px;
            }

            .auth-page-login .toggle-password {
                font-size: 12px;
            }

            .auth-page-login .auth-button {
                height: 52px;
                border-radius: 16px;
            }

            .auth-page-login .auth-glass {
                bottom: 28px;
                left: 28px;
                width: min(390px, calc(100% - 56px));
                padding: 24px;
            }

            .auth-page-login .auth-glass h2 {
                font-size: 30px;
                margin-bottom: 12px;
            }

            .auth-page-login .auth-glass p {
                font-size: 14px;
                line-height: 1.7;
            }
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            color: var(--inventra-muted);
        }

        .remember-label input {
            width: 16px;
            height: 16px;
            margin-right: 9px;
            border-radius: 5px;
            border-color: var(--inventra-border);
            color: var(--inventra-red);
        }

        .remember-label input:focus {
            box-shadow: 0 0 0 3px rgba(255, 44, 44, 0.16);
        }

        @media (max-width: 1024px) {
            html,
            body {
                overflow: auto;
            }
        }

        @media (max-width: 520px) {
            .login-options {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
                margin-bottom: 20px;
            }
        }
    </style>

    <main class="auth-page auth-page-login">
        <section class="auth-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=123"
                 alt="Ilustrasi manajemen inventaris">

            <div class="auth-glass">
                <h2>Kelola Inventaris Lebih Mudah</h2>
                <p>
                    Pantau barang, stok, peminjaman, dan laporan inventaris dalam satu sistem yang rapi.
                </p>
            </div>
        </section>

        <section class="auth-content">
            <div class="auth-form-wrap">
                <img src="{{ asset('images/inventra-logo-full.png') }}?v=123"
                     alt="Inventra Logo"
                     class="auth-logo">

                <p class="auth-subtitle">
                    Sistem manajemen PT Telkomsel untuk mengelola inventaris berbasis web
                </p>

                <h1 class="auth-title">Selamat Datang</h1>

                <p class="auth-description">
                    Masuk ke akun Inventra untuk mengelola data inventaris Anda.
                </p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>

                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="Masukkan email"
                               class="form-input">

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi</label>

                        <div class="password-box">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Masukkan kata sandi"
                                   class="form-input">

                            <button type="button" id="togglePassword" class="toggle-password">
                                Lihat
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="login-options">
                        <label for="remember_me" class="remember-label">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember">

                            Ingat saya
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <div class="auth-actions">
                        <button type="submit" class="auth-button">
                            Masuk
                        </button>
                    </div>

                    @if (Route::has('register'))
                        <p class="auth-helper-text">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="auth-link">
                                Daftar akun
                            </a>
                        </p>
                    @endif
                </form>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (!toggleButton || !passwordInput) {
                return;
            }

            toggleButton.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';

                passwordInput.type = isPassword ? 'text' : 'password';
                toggleButton.textContent = isPassword ? 'Sembunyikan' : 'Lihat';
            });
        });
    </script>
</x-guest-layout>
