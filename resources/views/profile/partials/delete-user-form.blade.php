<section x-data="{ confirmingUserDeletion: false }"
         class="bg-white rounded-3xl p-6 shadow-sm border border-red-100">
    <header>
        <p class="text-sm font-semibold text-red-500 mb-2">
            Area Berbahaya
        </p>

        <h2 class="text-2xl font-extrabold text-slate-900">
            Hapus Akun
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Setelah akun dihapus, seluruh data akun tidak dapat dipulihkan.
        </p>
    </header>

    <div class="mt-6 rounded-3xl bg-red-50 border border-red-100 p-5">
        <p class="text-sm font-semibold text-red-700 leading-7">
            Pastikan tindakan ini benar-benar diperlukan. Akun yang sudah dihapus tidak dapat digunakan kembali untuk masuk ke sistem.
        </p>

        <button type="button"
                @click="confirmingUserDeletion = true"
                class="mt-5 inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-red-600 text-white text-sm font-bold shadow-sm hover:bg-red-700 transition">
            Hapus Akun
        </button>
    </div>

    <div x-show="confirmingUserDeletion"
         x-transition
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/50"
             @click="confirmingUserDeletion = false"></div>

        <div class="relative w-full max-w-lg bg-white rounded-3xl p-6 shadow-xl">
            <h3 class="text-2xl font-extrabold text-slate-900">
                Konfirmasi Hapus Akun
            </h3>

            <p class="mt-3 text-sm text-slate-500 leading-7">
                Masukkan kata sandi Anda untuk menghapus akun secara permanen.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6 space-y-5">
                @csrf
                @method('DELETE')

                <div>
                    <label for="password_delete" class="block text-sm font-bold text-slate-700 mb-2">
                        Kata Sandi
                    </label>

                    <input id="password_delete"
                           name="password"
                           type="password"
                           autocomplete="current-password"
                           class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-red-500 focus:ring-red-500">

                    @error('password', 'userDeletion')
                        <p class="mt-2 text-sm font-semibold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button"
                            @click="confirmingUserDeletion = false"
                            class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition">
                        Batal
                    </button>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
