<x-guest-layout>
    @include('auth.partials.auth-responsive-style')

    <main class="auth-page">
        <section class="auth-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=120"
                 alt="Ilustrasi manajemen inventaris">

            <div class="auth-glass">
                <h2>Konfirmasi Akses Akun</h2>
                <p>
                    Masukkan kembali kata sandi untuk memastikan tindakan ini dilakukan oleh pemilik akun.
                </p>
            </div>
        </section>

        <section class="auth-content">
            <div class="auth-form-wrap">
                <img src="{{ asset('images/inventra-logo-full.png') }}?v=120"
                     alt="Inventra Logo"
                     class="auth-logo">

                <p class="auth-subtitle">
                    Sistem manajemen PT Telkomsel untuk mengelola inventaris berbasis web
                </p>

                <h1 class="auth-title">Konfirmasi Kata Sandi</h1>

                <p class="auth-description">
                    Ini adalah area aman. Masukkan kata sandi Anda sebelum melanjutkan proses.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

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

                    <div class="auth-actions">
                        <button type="submit" class="auth-button">
                            Konfirmasi
                        </button>
                    </div>
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
