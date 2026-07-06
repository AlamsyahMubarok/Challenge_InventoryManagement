<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventra') }}</title>

    <script>
        (function () {
            const savedTheme = localStorage.getItem('inventra-theme');

            if (
                savedTheme === 'dark' ||
                (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/inventra-favicon.png') }}?v=50">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/inventra-favicon.png') }}?v=50">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            color-scheme: light;
        }

        html.dark {
            color-scheme: dark;
        }

        html.dark .bg-\[\#f5f6fa\] {
            background-color: #020617 !important;
        }

        html.dark .bg-white {
            background-color: #0f172a !important;
        }

        html.dark .bg-slate-50 {
            background-color: #111827 !important;
        }

        html.dark .bg-slate-100 {
            background-color: #1e293b !important;
        }

        html.dark .bg-slate-900 {
            background-color: #020617 !important;
        }

        html.dark .bg-red-50 {
            background-color: rgba(255, 44, 44, 0.12) !important;
        }

        html.dark .bg-yellow-50 {
            background-color: rgba(234, 179, 8, 0.14) !important;
        }

        html.dark .bg-orange-50 {
            background-color: rgba(249, 115, 22, 0.14) !important;
        }

        html.dark .bg-green-50 {
            background-color: rgba(34, 197, 94, 0.14) !important;
        }

        html.dark .bg-sky-50 {
            background-color: rgba(14, 165, 233, 0.14) !important;
        }

        html.dark .text-slate-900 {
            color: #f8fafc !important;
        }

        html.dark .text-slate-800 {
            color: #e2e8f0 !important;
        }

        html.dark .text-slate-700 {
            color: #cbd5e1 !important;
        }

        html.dark .text-slate-600,
        html.dark .text-slate-500 {
            color: #94a3b8 !important;
        }

        html.dark .text-slate-400 {
            color: #64748b !important;
        }

        html.dark .text-red-600,
        html.dark .text-red-500 {
            color: #ff6b6b !important;
        }

        html.dark .text-yellow-700,
        html.dark .text-yellow-600 {
            color: #facc15 !important;
        }

        html.dark .text-green-700,
        html.dark .text-green-600 {
            color: #4ade80 !important;
        }

        html.dark .text-orange-700,
        html.dark .text-orange-600 {
            color: #fb923c !important;
        }

        html.dark .text-sky-700,
        html.dark .text-sky-600 {
            color: #38bdf8 !important;
        }

        html.dark .border-slate-100,
        html.dark .border-slate-200 {
            border-color: #1e293b !important;
        }

        html.dark .border-red-100 {
            border-color: rgba(255, 44, 44, 0.24) !important;
        }

        html.dark .border-yellow-100 {
            border-color: rgba(234, 179, 8, 0.28) !important;
        }

        html.dark .border-green-100 {
            border-color: rgba(34, 197, 94, 0.28) !important;
        }

        html.dark .border-sky-100 {
            border-color: rgba(14, 165, 233, 0.28) !important;
        }

        html.dark .divide-slate-100 > :not([hidden]) ~ :not([hidden]) {
            border-color: #223047 !important;
        }

        html.dark input,
        html.dark select,
        html.dark textarea {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        html.dark input::placeholder,
        html.dark textarea::placeholder {
            color: #64748b !important;
        }

        html.dark table thead tr,
        html.dark table thead tr.bg-slate-50 {
            background-color: #172033 !important;
            box-shadow: inset 0 -1px 0 #2a3850 !important;
        }

        html.dark table thead th {
            color: #cbd5e1 !important;
        }

        html.dark table tbody tr {
            border-color: #223047 !important;
        }

        html.dark table tbody tr:hover {
            background-color: rgba(30, 41, 59, 0.65) !important;
        }

        html.dark thead.sticky tr,
        html.dark thead.sticky tr.bg-slate-50 {
            background-color: #172033 !important;
        }

        html.dark thead.sticky th {
            color: #cbd5e1 !important;
        }

        html.dark aside .bg-slate-50 {
            background-color: rgba(255, 255, 255, 0.07) !important;
        }

        html.dark aside .bg-slate-100 {
            background-color: rgba(255, 255, 255, 0.10) !important;
        }

        html.dark .inventra-visible-button {
            background-color: rgba(255, 255, 255, 0.10) !important;
            color: #f8fafc !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
        }

        html.dark .inventra-visible-button:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
        }

        html.dark .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.45) !important;
        }

        html.dark .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.60), 0 8px 10px -6px rgba(0, 0, 0, 0.60) !important;
        }

        html.dark .inventra-success-popup-card {
            background-color: #0f172a !important;
            border-color: #273449 !important;
        }

        html.dark .inventra-success-popup-icon-wrap {
            background-color: rgba(255, 44, 44, 0.14) !important;
        }

        html.dark .inventra-success-popup-title {
            color: #f8fafc !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-[#f5f6fa] text-slate-900 transition-colors duration-300">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <div class="lg:pl-72">
            @isset($header)
                <header class="bg-[#f5f6fa] px-5 pt-6 sm:px-8 lg:px-10 transition-colors duration-300">
                    <div class="max-w-7xl mx-auto">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="px-5 py-6 sm:px-8 lg:px-10">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @php
        $popupSuccess = session('popup_success');
    @endphp

    @if ($popupSuccess)
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 2600)"
             x-transition.opacity.duration.300ms
             x-cloak
             class="fixed inset-0 z-[99999] flex items-center justify-center bg-slate-900/30 backdrop-blur-[3px] px-5">

            <div x-show="show"
                 x-transition.scale.origin.center.duration.300ms
                 class="inventra-success-popup-card w-full max-w-[460px] min-h-[430px] rounded-[2.5rem] bg-white border border-slate-100 shadow-2xl px-10 py-10 text-center flex flex-col items-center justify-center">

                <div class="inventra-success-popup-icon-wrap mx-auto w-40 h-40 rounded-full bg-red-50 flex items-center justify-center">
                    <img src="{{ $popupSuccess['icon'] ?? asset('images/checklist.png') }}"
                         alt="Popup Icon"
                         class="w-28 h-28 object-contain">
                </div>

                <h2 class="inventra-success-popup-title mt-8 text-[26px] font-semibold leading-9 text-slate-900 max-w-[330px]">
                    {{ $popupSuccess['title'] ?? 'Data Berhasil Ditambahkan' }}
                </h2>

                <img src="{{ asset('images/checklist.png') }}?v=20"
                     alt="Berhasil"
                     class="mt-6 mx-auto w-24 h-24 object-contain">

                <button type="button"
                        @click="show = false"
                        class="sr-only">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const root = document.documentElement;

            function updateThemeIcons() {
                const isDark = root.classList.contains('dark');

                document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
                    const moonIcon = button.querySelector('[data-theme-icon="moon"]');
                    const sunIcon = button.querySelector('[data-theme-icon="sun"]');

                    if (! moonIcon || ! sunIcon) {
                        return;
                    }

                    if (isDark) {
                        moonIcon.classList.add('hidden');
                        sunIcon.classList.remove('hidden');
                        button.setAttribute('title', 'Aktifkan Light Mode');
                    } else {
                        moonIcon.classList.remove('hidden');
                        sunIcon.classList.add('hidden');
                        button.setAttribute('title', 'Aktifkan Dark Mode');
                    }
                });
            }

            document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const isDark = root.classList.toggle('dark');

                    localStorage.setItem('inventra-theme', isDark ? 'dark' : 'light');

                    updateThemeIcons();
                });
            });

            updateThemeIcons();
        });
    </script>

    @auth
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const timeoutMinutes = Number(@json((int) config('session.lifetime', 30))) || 30;
                const timeoutMilliseconds = timeoutMinutes * 60 * 1000;
                const storageKey = 'inventra_last_activity_at';

                let logoutTimer = null;
                let isLoggingOut = false;
                let lastWriteAt = 0;

                function now() {
                    return Date.now();
                }

                function getLastActivity() {
                    const storedValue = localStorage.getItem(storageKey);
                    const timestamp = Number(storedValue);

                    if (!storedValue || Number.isNaN(timestamp)) {
                        return now();
                    }

                    return timestamp;
                }

                function setLastActivity(force = false) {
                    const currentTime = now();

                    if (!force && currentTime - lastWriteAt < 1000) {
                        return;
                    }

                    lastWriteAt = currentTime;
                    localStorage.setItem(storageKey, String(currentTime));
                }

                function getInactiveDuration() {
                    return now() - getLastActivity();
                }

                function getRemainingTime() {
                    return Math.max(1000, timeoutMilliseconds - getInactiveDuration());
                }

                function resetLogoutTimer() {
                    if (logoutTimer) {
                        clearTimeout(logoutTimer);
                    }

                    logoutTimer = setTimeout(function () {
                        checkSessionTimeout();
                    }, getRemainingTime());
                }

                function checkSessionTimeout() {
                    if (isLoggingOut) {
                        return;
                    }

                    if (getInactiveDuration() >= timeoutMilliseconds) {
                        logoutUser();
                        return;
                    }

                    resetLogoutTimer();
                }

                function handleActivity() {
                    if (isLoggingOut) {
                        return;
                    }

                    if (getInactiveDuration() >= timeoutMilliseconds) {
                        logoutUser();
                        return;
                    }

                    setLastActivity();
                    resetLogoutTimer();
                }

                function logoutUser() {
                    if (isLoggingOut) {
                        return;
                    }

                    isLoggingOut = true;

                    try {
                        localStorage.removeItem(storageKey);
                    } catch (error) {
                        //
                    }

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    if (!csrfToken) {
                        window.location.replace("{{ route('login') }}?timeout=1");
                        return;
                    }

                    fetch("{{ route('logout') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    }).finally(function () {
                        window.location.replace("{{ route('login') }}?timeout=1");
                    });
                }

                const activityEvents = [
                    'click',
                    'keydown',
                    'scroll',
                    'touchstart',
                    'pointermove'
                ];

                activityEvents.forEach(function (eventName) {
                    window.addEventListener(eventName, handleActivity, {
                        passive: true
                    });
                });

                document.addEventListener('visibilitychange', function () {
                    if (document.visibilityState === 'visible') {
                        handleActivity();
                    }
                });

                window.addEventListener('storage', function (event) {
                    if (event.key !== storageKey) {
                        return;
                    }

                    if (event.newValue === null && !isLoggingOut) {
                        window.location.replace("{{ route('login') }}?timeout=1");
                        return;
                    }

                    resetLogoutTimer();
                });

                setLastActivity(true);
                resetLogoutTimer();
            });
        </script>
    @endauth
</body>
</html>
