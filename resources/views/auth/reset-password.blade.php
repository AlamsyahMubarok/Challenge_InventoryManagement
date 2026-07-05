<x-guest-layout>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .reset-page {
            min-height: 100vh;
            width: 100%;
            background: #ffffff;
            display: grid;
            grid-template-columns: 58% 42%;
        }

        .reset-illustration {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: #f8fafc;
        }

        .reset-illustration img {
            width: 100%;
            height: 100%;
            min-height: 100vh;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .reset-illustration::after {
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

        .reset-glass {
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

        .reset-glass h2 {
            margin: 0 0 14px;
            font-size: 38px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .reset-glass p {
            margin: 0;
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.92);
        }

        .reset-content {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 46px 76px;
        }

        .reset-form-wrap {
            width: 100%;
            max-width: 480px;
        }

        .reset-logo {
            width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 8px;
        }

        .reset-subtitle {
            margin: 0 0 48px;
            text-align: center;
            font-size: 16px;
            line-height: 1.6;
            color: #6b7280;
        }

        .reset-title {
            margin: 0 0 14px;
            font-size: 40px;
            line-height: 1.15;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.03em;
        }

        .reset-description {
            margin: 0 0 30px;
            font-size: 17px;
            line-height: 1.8;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 20px;
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
            height: 60px;
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

        .reset-button {
            width: 100%;
            height: 62px;
            border: none;
            border-radius: 18px;
            background: #FF2C2C;
            color: #ffffff;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 16px 34px rgba(255, 44, 44, 0.28);
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .reset-button:hover {
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

        .reset-link {
            color: #FF2C2C;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .reset-link:hover {
            color: #D91F1F;
            text-decoration: underline;
        }

        @media (max-width: 1280px) {
            .reset-content {
                padding: 40px 58px;
            }

            .reset-form-wrap {
                max-width: 450px;
            }

            .reset-logo {
                width: 280px;
            }

            .reset-title {
                font-size: 36px;
            }

            .reset-description {
                font-size: 16px;
            }

            .form-input {
                height: 56px;
            }

            .reset-button {
                height: 58px;
            }
        }

        @media (max-width: 1024px) {
            .reset-page {
                grid-template-columns: 1fr;
            }

            .reset-illustration {
                display: none;
            }

            .reset-content {
                padding: 42px 28px;
            }

            .reset-form-wrap {
                max-width: 460px;
            }
        }

        @media (max-width: 520px) {
            .reset-content {
                padding: 34px 22px;
            }

            .reset-logo {
                width: 230px;
            }

            .reset-subtitle {
                margin-bottom: 36px;
                font-size: 14px;
            }

            .reset-title {
                font-size: 30px;
            }

            .reset-description {
                font-size: 15px;
                margin-bottom: 28px;
            }

            .form-input {
                height: 54px;
                font-size: 14px;
                border-radius: 16px;
            }

            .reset-button {
                height: 56px;
                border-radius: 16px;
            }
        }
    </style>

    <main class="reset-page">
        <section class="reset-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=90"
                 alt="Ilustrasi manajemen inventaris">

            <div class="reset-glass">
                <h2>Atur Ulang Kata Sandi</h2>
                <p>
                    Buat kata sandi baru agar Anda dapat kembali mengakses akun Inventra dengan aman.
                </p>
            </div>
        </section>

        <section class="reset-content">
            <div class="reset-form-wrap">
                <img src="{{ asset('images/inventra-logo-full.png') }}?v=90"
                     alt="Inventra Logo"
                     class="reset-logo">

                <p class="reset-subtitle">
                    Sistem manajemen PT Telkomsel untuk mengelola inventaris berbasis web
                </p>

                <h1 class="reset-title">
                    Buat Kata Sandi Baru
                </h1>

                <p class="reset-description">
                    Masukkan kata sandi baru untuk akun Inventra Anda. Pastikan kata sandi mudah diingat dan tetap aman.
                </p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>

                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email', $request->email) }}"
                               required
                               autocomplete="username"
                               class="form-input">

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi Baru</label>

                        <div class="password-box">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autofocus
                                   autocomplete="new-password"
                                   placeholder="Masukkan kata sandi baru"
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
                                   placeholder="Ulangi kata sandi baru"
                                   class="form-input">

                            <button type="button" id="togglePasswordConfirmation" class="toggle-password">
                                Lihat
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit" class="reset-button">
                        Simpan Kata Sandi Baru
                    </button>

                    <p class="login-text">
                        Sudah ingat kata sandi?
                        <a href="{{ route('login') }}" class="reset-link">
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
