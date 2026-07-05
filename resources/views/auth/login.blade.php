<x-guest-layout>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .login-page {
            min-height: 100vh;
            width: 100%;
            background: #ffffff;
            display: grid;
            grid-template-columns: 58% 42%;
        }

        .login-illustration {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: #f8fafc;
        }

        .login-illustration img {
            width: 100%;
            height: 100%;
            min-height: 100vh;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .login-illustration::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(255, 255, 255, 0.03) 0%,
                rgba(255, 44, 44, 0.07) 100%
            );
            pointer-events: none;
        }

        .login-glass {
            position: absolute;
            left: 42px;
            bottom: 42px;
            width: 460px;
            max-width: calc(100% - 84px);
            padding: 30px;
            border-radius: 24px;
            background: rgba(17, 24, 39, 0.52);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            color: #ffffff;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);
            z-index: 2;
        }

        .login-glass h2 {
            margin: 0 0 14px;
            font-size: 38px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .login-glass p {
            margin: 0;
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.92);
        }

        .login-content {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px 76px;
        }

        .login-form-wrap {
            width: 100%;
            max-width: 480px;
        }

        .login-logo {
            width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 8px;
        }

        .login-subtitle {
            margin: 0 0 58px;
            text-align: center;
            font-size: 17px;
            line-height: 1.6;
            color: #6b7280;
        }

        .login-title {
            margin: 0 0 14px;
            font-size: 42px;
            line-height: 1.15;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.03em;
        }

        .login-description {
            margin: 0 0 38px;
            font-size: 17px;
            line-height: 1.8;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .form-input {
            width: 100%;
            height: 64px;
            border: 1px solid #d1d5db;
            border-radius: 20px;
            padding: 0 20px;
            background: #ffffff;
            font-size: 16px;
            color: #111827;
            transition: all 0.2s ease;
        }

        .form-input::placeholder {
            font-size: 15px;
            color: #9ca3af;
        }

        .form-input:focus {
            border-color: #FF2C2C;
            box-shadow: 0 0 0 4px rgba(255, 44, 44, 0.14);
            outline: none;
        }

        .password-box {
            position: relative;
        }

        .password-box .form-input {
            padding-right: 96px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .toggle-password:hover {
            color: #111827;
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 28px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            font-size: 15px;
            color: #6b7280;
        }

        .remember-label input {
            width: 17px;
            height: 17px;
            margin-right: 9px;
            border-radius: 5px;
            border-color: #d1d5db;
            color: #FF2C2C;
        }

        .remember-label input:focus {
            box-shadow: 0 0 0 3px rgba(255, 44, 44, 0.16);
        }

        .login-link {
            color: #FF2C2C;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .login-link:hover {
            color: #D91F1F;
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            height: 64px;
            border: none;
            border-radius: 20px;
            background: #FF2C2C;
            color: #ffffff;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 16px 34px rgba(255, 44, 44, 0.28);
            transition: all 0.2s ease;
        }

        .login-button:hover {
            background: #D91F1F;
            transform: translateY(-1px);
            box-shadow: 0 18px 38px rgba(217, 31, 31, 0.32);
        }

        .register-text {
            margin-top: 26px;
            text-align: center;
            font-size: 15px;
            color: #6b7280;
        }

        @media (max-width: 1280px) {
            .login-content {
                padding: 48px 58px;
            }

            .login-form-wrap {
                max-width: 450px;
            }

            .login-logo {
                width: 280px;
            }

            .login-title {
                font-size: 38px;
            }

            .login-description {
                font-size: 16px;
            }

            .form-input {
                height: 60px;
            }

            .login-button {
                height: 60px;
            }
        }

        @media (max-width: 1024px) {
            .login-page {
                grid-template-columns: 1fr;
            }

            .login-illustration {
                display: none;
            }

            .login-content {
                padding: 42px 28px;
            }

            .login-form-wrap {
                max-width: 460px;
            }
        }

        @media (max-width: 520px) {
            .login-content {
                padding: 34px 22px;
            }

            .login-logo {
                width: 230px;
            }

            .login-subtitle {
                margin-bottom: 42px;
                font-size: 14px;
            }

            .login-title {
                font-size: 30px;
            }

            .login-description {
                font-size: 15px;
                margin-bottom: 30px;
            }

            .form-input {
                height: 56px;
                font-size: 14px;
                border-radius: 16px;
            }

            .login-button {
                height: 56px;
                border-radius: 16px;
            }

            .login-options {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>

    <main class="login-page">
        <section class="login-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=60"
                 alt="Ilustrasi manajemen inventaris">

            <div class="login-glass">
                <h2>Kelola Inventaris Lebih Mudah</h2>
                <p>
                    Pantau barang, stok, peminjaman, dan laporan inventaris dalam satu sistem yang rapi.
                </p>
            </div>
        </section>

        <section class="login-content">
            <div class="login-form-wrap">
                <img src="{{ asset('images/inventra-logo-full.png') }}?v=60"
                     alt="Inventra Logo"
                     class="login-logo">

                <p class="login-subtitle">
                    Sistem manajemen PT Telkomsel untuk mengelola inventaris berbasis web
                </p>

                <h1 class="login-title">
                    Selamat Datang
                </h1>

                <p class="login-description">
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
                            <a href="{{ route('password.request') }}" class="login-link">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-button">
                        Masuk
                    </button>

                    @if (Route::has('register'))
                        <p class="register-text">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="login-link">
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
