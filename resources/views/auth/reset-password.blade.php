<x-guest-layout>
    @include('auth.partials.auth-responsive-style')

    <main class="auth-page">
        <section class="auth-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=120"
                 alt="Ilustrasi manajemen inventaris">

            <div class="auth-glass">
                <h2>Atur Ulang Kata Sandi</h2>
                <p>
                    Buat kata sandi baru agar Anda dapat kembali mengakses akun Inventra dengan aman.
                </p>
            </div>
        </section>

        <section class="auth-content">
            <div class="auth-form-wrap is-compact">
                <img src="{{ asset('images/inventra-logo-full.png') }}?v=120"
                     alt="Inventra Logo"
                     class="auth-logo">

                <p class="auth-subtitle">
                    Sistem manajemen PT Telkomsel untuk mengelola inventaris berbasis web
                </p>

                <h1 class="auth-title">Buat Kata Sandi Baru</h1>

                <p class="auth-description">
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

                    <div class="auth-actions">
                        <button type="submit" class="auth-button">
                            Simpan Kata Sandi Baru
                        </button>
                    </div>

                    <p class="auth-helper-text">
                        Sudah ingat kata sandi?
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
