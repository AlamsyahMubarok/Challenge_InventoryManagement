<section class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
    <header>
        <p class="text-sm font-semibold text-red-500 mb-2">
            Keamanan Akun
        </p>

        <h2 class="text-2xl font-extrabold text-slate-900">
            Ubah Kata Sandi
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Gunakan kata sandi yang kuat agar akun tetap aman.
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="current_password" class="block text-sm font-bold text-slate-700 mb-2">
                Kata Sandi Saat Ini
            </label>

            <input id="current_password"
                   name="current_password"
                   type="password"
                   autocomplete="current-password"
                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">

            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-bold text-slate-700 mb-2">
                Kata Sandi Baru
            </label>

            <input id="password"
                   name="password"
                   type="password"
                   autocomplete="new-password"
                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">

            @error('password', 'updatePassword')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">
                Konfirmasi Kata Sandi Baru
            </label>

            <input id="password_confirmation"
                   name="password_confirmation"
                   type="password"
                   autocomplete="new-password"
                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">

            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            @if (session('status') === 'password-updated')
                <p class="text-sm font-semibold text-green-600">
                    Tersimpan.
                </p>
            @endif

            <button type="submit"
                    class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-bold shadow-sm hover:bg-slate-800 transition">
                Perbarui Kata Sandi
            </button>
        </div>
    </form>
</section>
