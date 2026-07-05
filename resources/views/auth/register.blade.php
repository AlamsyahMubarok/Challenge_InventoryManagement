<x-guest-layout>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .register-page {
            min-height: 100vh;
            width: 100%;
            background: #ffffff;
            display: grid;
            grid-template-columns: 58% 42%;
        }

        .register-illustration {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: #f8fafc;
        }

        .register-illustration img {
            width: 100%;
            height: 100%;
            min-height: 100vh;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .register-illustration::after {
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

        .register-glass {
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

        .register-glass h2 {
            margin: 0 0 14px;
            font-size: 38px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .register-glass p {
            margin: 0;
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.92);
        }

        .register-content {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 44px 76px;
        }

        .register-form-wrap {
            width: 100%;
            max-width: 480px;
        }

        .register-logo {
            width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 8px;
        }

        .register-subtitle {
            margin: 0 0 42px;
            text-align: center;
            font-size: 16px;
            line-height: 1.6;
            color: #6b7280;
        }

        .register-title {
            margin: 0 0 14px;
            font-size: 40px;
            line-height: 1.15;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.03em;
        }

        .register-description {
            margin: 0 0 30px;
            font-size: 17px;
            line-height: 1.8;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            margin-bottom: 9px;
            font-size: 15px;
            font-weight: 700;
            color: #111827;
        }

        .form-input {
            width: 100%;
            height: 58px;
            border: 1px solid #d1d5db;
            border-radius: 18px;
            padding: 0 18px;
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
            padding-right: 112px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .toggle-password:hover {
            color: #111827;
        }

        .register-actions {
            margin-top: 26px;
        }

        .register-button {
            width: 100%;
            height: 60px;
            border: none;
            border-radius: 18px;
            background: #FF2C2C;
            color: #ffffff;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 16px 34px rgba(255, 44, 44, 0.28);
            transition: all 0.2s ease;
        }

        .register-button:hover {
            background: #D91F1F;
            transform: translateY(-1px);
            box-shadow: 0 18px 38px rgba(217, 31, 31, 0.32);
        }

        .login-text {
            margin-top: 24px;
            text-align: center;
            font-size: 15px;
            color: #6b7280;
        }

        .register-link {
            color: #FF2C2C;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .register-link:hover {
            color: #D91F1F;
            text-decoration: underline;
        }

        @media (max-width: 1280px) {
            .register-content {
                padding: 40px 58px;
            }

            .register-form-wrap {
                max-width: 450px;
            }

            .register-logo {
                width: 280px;
            }

            .register-title {
                font-size: 36px;
            }

            .register-description {
                font-size: 16px;
            }

            .form-input {
                height: 56px;
            }

            .register-button {
                height: 58px;
            }
        }

        @media (max-width: 1024px) {
            .register-page {
                grid-template-columns: 1fr;
            }

            .register-illustration {
                display: none;
            }

            .register-content {
                padding: 42px 28px;
            }

            .register-form-wrap {
                max-width: 460px;
            }
        }

        @media (max-width: 520px) {
            .register-content {
                padding: 34px 22px;
            }

            .register-logo {
                width: 230px;
            }

            .register-subtitle {
                margin-bottom: 34px;
                font-size: 14px;
            }

            .register-title {
                font-size: 30px;
            }

            .register-description {
                font-size: 15px;
                margin-bottom: 28px;
            }

            .form-input {
                height: 54px;
                font-size: 14px;
                border-radius: 16px;
            }

            .register-button {
                height: 56px;
                border-radius: 16px;
            }
        }
    </style>

    <main class="register-page">
        <section class="register-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=70"
                 alt="Ilustrasi manajemen inventaris">

            <div class="register-glass">
                <h2>Mulai Kelola Inventaris</h2>
                <p>
                    Buat akun Inventra untuk mencatat barang, memantau stok, dan mengelola peminjaman inventaris.
                </p>
            </div>
        </section>

        <section class="register-content">
            <div class="register-form-wrap">
                <img src="{{ asset('images/inventra-logo-full.png') }}?v=70"
                     alt="Inventra Logo"
                     class="register-logo">

                <p class="register-subtitle">
                    Sistem manajemen PT Telkomsel untuk mengelola inventaris berbasis web
                </p>

                <h1 class="register-title">
                    Buat Akun
                </h1>

                <p class="register-description">
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

                    <div class="register-actions">
                        <button type="submit" class="register-button">
                            Daftar
                        </button>

                        <p class="login-text">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="register-link">
                                Masuk
                            </a>
                        </p>
                    </div>
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
