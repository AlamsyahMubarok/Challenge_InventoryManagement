<x-app-layout>
    <div class="space-y-6">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold text-red-500 mb-2">
                    Pengaturan Akun
                </p>

                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Profil
                </h1>

                <p class="mt-2 text-slate-500">
                    Kelola informasi akun, keamanan kata sandi, dan pengaturan profil pengguna.
                </p>
            </div>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="rounded-2xl bg-green-50 border border-green-100 px-5 py-4 text-green-700 text-sm font-semibold">
                Profil berhasil diperbarui.
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="rounded-2xl bg-green-50 border border-green-100 px-5 py-4 text-green-700 text-sm font-semibold">
                Kata sandi berhasil diperbarui.
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-[380px_minmax(0,1fr)] gap-6 items-start">

            <aside class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <div class="rounded-3xl bg-gradient-to-br from-red-500 via-orange-500 to-yellow-400 p-6 text-white overflow-hidden">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-3xl bg-white/20 backdrop-blur flex items-center justify-center">
                            <img src="{{ asset('images/profil.png') }}?v=120"
                                 alt="Profil"
                                 class="w-14 h-14 object-contain">
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-white/80">
                                Login sebagai
                            </p>

                            <h2 class="mt-1 text-2xl font-extrabold leading-tight">
                                {{ $user->name }}
                            </h2>

                            <p class="mt-1 text-sm font-semibold text-white/80">
                                {{ ucfirst($user->role?->name ?? 'User') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wide">
                            Nama Pengguna
                        </p>

                        <p class="mt-2 text-sm font-extrabold text-slate-800">
                            {{ $user->name }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wide">
                            Email
                        </p>

                        <p class="mt-2 text-sm font-extrabold text-slate-800 break-all">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wide">
                            Hak Akses
                        </p>

                        <p class="mt-2 inline-flex items-center px-3 py-1.5 rounded-full bg-red-50 text-red-600 border border-red-100 text-xs font-extrabold">
                            {{ ucfirst($user->role?->name ?? 'User') }}
                        </p>
                    </div>
                </div>
            </aside>

            <div class="space-y-6">
                @include('profile.partials.update-profile-information-form')

                @include('profile.partials.update-password-form')

            </div>

        </div>
    </div>
</x-app-layout>
