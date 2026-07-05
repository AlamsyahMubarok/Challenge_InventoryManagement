<section class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
    <header>
        <p class="text-sm font-semibold text-red-500 mb-2">
            Informasi Profil
        </p>

        <h2 class="text-2xl font-extrabold text-slate-900">
            Data Akun
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Perbarui nama dan alamat email yang digunakan pada akun Inventra.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('PATCH')

        <div>
            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">
                Nama
            </label>

            <input id="name"
                   name="name"
                   type="text"
                   value="{{ old('name', $user->name) }}"
                   required
                   autofocus
                   autocomplete="name"
                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">

            @error('name')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-slate-700 mb-2">
                Email
            </label>

            <input id="email"
                   name="email"
                   type="email"
                   value="{{ old('email', $user->email) }}"
                   required
                   autocomplete="username"
                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">

            @error('email')
                <p class="mt-2 text-sm font-semibold text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            @if (session('status') === 'profile-updated')
                <p class="text-sm font-semibold text-green-600">
                    Tersimpan.
                </p>
            @endif

            <button type="submit"
                    class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold shadow-sm hover:bg-[#D91F1F] transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</section>
