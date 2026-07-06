<x-guest-layout>
    @include('auth.partials.auth-responsive-style')

    <main class="auth-page">
        <section class="auth-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=120"
                 alt="Ilustrasi manajemen inventaris">

            <div class="auth-glass">
                <h2>Pulihkan Akses Akun</h2>
                <p>
                    Masukkan email akun Inventra Anda. Sistem akan mengirimkan link untuk mengatur ulang kata sandi.
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

                <h1 class="auth-title">Lupa Kata Sandi</h1>

                <p class="auth-description">
                    Masukkan alamat email yang terdaftar. Kami akan mengirimkan link reset kata sandi ke email Anda.
                </p>

                @if (session('status'))
                    <div class="auth-status">
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

                    <div class="auth-actions">
                        <button type="submit" class="auth-button">
                            Kirim Link Reset Password
                        </button>
                    </div>

                    <p class="auth-helper-text">
                        Ingat kata sandi?
                        <a href="{{ route('login') }}" class="auth-link">
                            Masuk
                        </a>
                    </p>
                </form>
            </div>
        </section>
    </main>
</x-guest-layout>
