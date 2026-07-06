<x-guest-layout>
    @include('auth.partials.auth-responsive-style')

    <style>
        @media (min-width: 1025px) {
            html,
            body {
                height: 100%;
                overflow: hidden;
            }

            .auth-page-register {
                height: 100svh;
                min-height: 100svh;
                overflow: hidden;
            }

            .auth-page-register .auth-illustration {
                height: 100svh;
                min-height: 100svh;
                overflow: hidden;
            }

            .auth-page-register .auth-illustration img {
                width: 100%;
                height: 100%;
                min-height: 100%;
                object-fit: cover;
                object-position: center center;
                display: block;
            }

            .auth-page-register .auth-content {
                height: 100svh;
                min-height: 100svh;
                overflow: hidden;
                padding-top: 18px;
                padding-bottom: 18px;
            }

            .auth-page-register .auth-form-wrap {
                margin-block: auto;
            }

            .auth-page-register .auth-logo {
                width: 170px;
                margin-bottom: 4px;
            }

            .auth-page-register .auth-subtitle {
                margin-bottom: 16px;
                font-size: 12px;
                line-height: 1.5;
            }

            .auth-page-register .auth-title {
                font-size: 28px;
                margin-bottom: 8px;
            }

            .auth-page-register .auth-description {
                margin-bottom: 14px;
                font-size: 13px;
                line-height: 1.55;
            }

            .auth-page-register .form-group {
                margin-bottom: 10px;
            }

            .auth-page-register .form-label {
                margin-bottom: 6px;
                font-size: 13px;
            }

            .auth-page-register .form-input {
                height: 46px;
                border-radius: 16px;
                font-size: 14px;
            }

            .auth-page-register .form-input::placeholder {
                font-size: 13px;
            }

            .auth-page-register .password-box .form-input {
                padding-right: 92px;
            }

            .auth-page-register .toggle-password {
                font-size: 12px;
            }

            .auth-page-register .auth-actions {
                margin-top: 16px;
            }

            .auth-page-register .auth-button {
                height: 50px;
                border-radius: 16px;
            }

            .auth-page-register .auth-helper-text {
                margin-top: 14px;
                font-size: 13px;
            }

            .auth-page-register .auth-glass {
                bottom: 28px;
                left: 28px;
                width: min(390px, calc(100% - 56px));
                padding: 24px;
            }

            .auth-page-register .auth-glass h2 {
                font-size: 30px;
                margin-bottom: 12px;
            }

            .auth-page-register .auth-glass p {
                font-size: 14px;
                line-height: 1.7;
            }
        }

        @media (max-width: 1024px) {
            html,
            body {
                overflow: auto;
            }
        }
    </style>

    <main class="auth-page auth-page-register">
        <section class="auth-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=122"
                 alt="Ilustrasi manajemen inventaris">

            <div class="auth-glass">
                <h2>Mulai Kelola Inventaris</h2>
                <p>
                    Buat akun Inventra untuk mencatat barang, memantau stok, dan mengelola peminjaman inventaris.
                </p>
            </div>
        </section>

        <section class="auth-content">
            <div class="auth-form-wrap is-compact">
                <img src="{{ asset('images/inventra-logo-full.png') }}?v=122"
                     alt="Inventra Logo"
                     class="auth-logo">

                <p class="auth-subtitle">
                    Sistem manajemen PT Telkomsel untuk mengelola inventaris berbasis web
                </p>

                <h1 class="auth-title">Buat Akun</h1>

                <p class="auth-description">
                    Daftar sebagai pengguna Inventra untuk mulai mengakses sistem inventaris.
                </p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Nama</label>

                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name"
                               placeholder="Masukkan nama lengkap"
                               class="form-input">

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>

                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
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
                                   autocomplete="new-password"
                                   placeholder="Masukkan kata sandi"
                                   class="form-input">

                            <button type="button" id="togglePassword" class="toggle-password">
                                Lihat
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>

                        <div class="password-box">
                            <input id="password_confirmation"
                                   type="password"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Ulangi kata sandi"
                                   class="form-input">

                            <button type="button" id="togglePasswordConfirmation" class="toggle-password">
                                Lihat
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="auth-actions">
                        <button type="submit" class="auth-button">
                            Daftar
                        </button>
                    </div>

                    <p class="auth-helper-text">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="auth-link">
                            Masuk
                        </a>
                    </p>
                </form>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupPasswordToggle(buttonId, inputId) {
                const toggleButton = document.getElementById(buttonId);
                const passwordInput = document.getElementById(inputId);

                if (!toggleButton || !passwordInput) {
                    return;
                }

                toggleButton.addEventListener('click', function () {
                    const isPassword = passwordInput.type === 'password';

                    passwordInput.type = isPassword ? 'text' : 'password';
                    toggleButton.textContent = isPassword ? 'Sembunyikan' : 'Lihat';
                });
            }

            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation');
        });
    </script>
</x-guest-layout>
