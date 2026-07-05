<x-guest-layout>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .forgot-page {
            min-height: 100vh;
            width: 100%;
            background: #ffffff;
            display: grid;
            grid-template-columns: 58% 42%;
        }

        .forgot-illustration {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: #f8fafc;
        }

        .forgot-illustration img {
            width: 100%;
            height: 100%;
            min-height: 100vh;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .forgot-illustration::after {
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

        .forgot-glass {
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

        .forgot-glass h2 {
            margin: 0 0 14px;
            font-size: 38px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .forgot-glass p {
            margin: 0;
            font-size: 16px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.92);
        }

        .forgot-content {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px 76px;
        }

        .forgot-form-wrap {
            width: 100%;
            max-width: 480px;
        }

        .forgot-logo {
            width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 8px;
        }

        .forgot-subtitle {
            margin: 0 0 58px;
            text-align: center;
            font-size: 16px;
            line-height: 1.6;
            color: #6b7280;
        }

        .forgot-title {
            margin: 0 0 14px;
            font-size: 42px;
            line-height: 1.15;
            font-weight: 800;
            color: #111827;
            letter-spacing: -0.03em;
        }

        .forgot-description {
            margin: 0 0 34px;
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

        .forgot-button {
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

        .forgot-button:hover {
            background: #D91F1F;
            transform: translateY(-1px);
            box-shadow: 0 18px 38px rgba(217, 31, 31, 0.32);
        }

        .login-text {
            margin-top: 26px;
            text-align: center;
            font-size: 15px;
            color: #6b7280;
        }

        .forgot-link {
            color: #FF2C2C;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: #D91F1F;
            text-decoration: underline;
        }

        .status-box {
            margin-bottom: 24px;
            padding: 16px 18px;
            border-radius: 16px;
            background: #ecfdf5;
            color: #047857;
            font-size: 15px;
            line-height: 1.6;
        }

        @media (max-width: 1280px) {
            .forgot-content {
                padding: 48px 58px;
            }

            .forgot-form-wrap {
                max-width: 450px;
            }

            .forgot-logo {
                width: 280px;
            }

            .forgot-title {
                font-size: 38px;
            }

            .forgot-description {
                font-size: 16px;
            }

            .form-input {
                height: 60px;
            }

            .forgot-button {
                height: 60px;
            }
        }

        @media (max-width: 1024px) {
            .forgot-page {
                grid-template-columns: 1fr;
            }

            .forgot-illustration {
                display: none;
            }

            .forgot-content {
                padding: 42px 28px;
            }

            .forgot-form-wrap {
                max-width: 460px;
            }
        }

        @media (max-width: 520px) {
            .forgot-content {
                padding: 34px 22px;
            }

            .forgot-logo {
                width: 230px;
            }

            .forgot-subtitle {
                margin-bottom: 42px;
                font-size: 14px;
            }

            .forgot-title {
                font-size: 30px;
            }

            .forgot-description {
                font-size: 15px;
                margin-bottom: 30px;
            }

            .form-input {
                height: 56px;
                font-size: 14px;
                border-radius: 16px;
            }

            .forgot-button {
                height: 56px;
                border-radius: 16px;
            }
        }
    </style>

    <main class="forgot-page">
        <section class="forgot-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=80"
                 alt="Ilustrasi manajemen inventaris">

            <div class="forgot-glass">
                <h2>Pulihkan Akses Akun</h2>
                <p>
                    Masukkan email akun Inventra Anda. Sistem akan mengirimkan link untuk mengatur ulang kata sandi.
                </p>
            </div>
        </section>

        <section class="forgot-content">
            <div class="forgot-form-wrap">
                <img src="{{ asset('images/inventra-logo-full.png') }}?v=80"
                     alt="Inventra Logo"
                     class="forgot-logo">

                <p class="forgot-subtitle">
                    Sistem manajemen PT Telkomsel untuk mengelola inventaris berbasis web
                </p>

                <h1 class="forgot-title">
                    Lupa Kata Sandi
                </h1>

                <p class="forgot-description">
                    Masukkan alamat email yang terdaftar. Kami akan mengirimkan link reset kata sandi ke email Anda.
                </p>

                @if (session('status'))
                    <div class="status-box">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
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

                    <button type="submit" class="forgot-button">
                        Kirim Link Reset Password
                    </button>

                    <p class="login-text">
                        Ingat kata sandi?
                        <a href="{{ route('login') }}" class="forgot-link">
                            Masuk
                        </a>
                    </p>
                </form>
            </div>
        </section>
    </main>
</x-guest-layout>
