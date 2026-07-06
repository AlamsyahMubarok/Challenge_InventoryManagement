<x-guest-layout>
    @include('auth.partials.auth-responsive-style')

    <main class="auth-page">
        <section class="auth-illustration">
            <img src="{{ asset('images/vektor-perusahaan.jpg') }}?v=120"
                 alt="Ilustrasi manajemen inventaris">

            <div class="auth-glass">
                <h2>Verifikasi Email Akun</h2>
                <p>
                    Pastikan alamat email Anda aktif agar akun Inventra dapat digunakan dengan aman.
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

                <h1 class="auth-title">Verifikasi Email</h1>

                <div class="auth-info-box">
                    Terima kasih sudah mendaftar. Sebelum mulai menggunakan Inventra, verifikasi alamat email Anda melalui link yang sudah kami kirimkan. Jika email belum diterima, Anda dapat mengirim ulang link verifikasi.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="auth-status">
                        Link verifikasi baru berhasil dikirim ke alamat email yang Anda gunakan saat registrasi.
                    </div>
                @endif

                <div class="auth-actions">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <button type="submit" class="auth-button">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit" class="auth-secondary-button">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>
</x-guest-layout>
