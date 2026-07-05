<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventra') }}</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/inventra-favicon.png') }}?v=40">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/inventra-favicon.png') }}?v=40">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    @if (
    request()->routeIs('login') ||
    request()->routeIs('register') ||
    request()->routeIs('password.request') ||
    request()->routeIs('password.reset')
    )
    {{ $slot }}
    @else
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <img src="{{ asset('images/inventra-logo-full.png') }}?v=40"
                         alt="Inventra Logo"
                         style="width: 220px; height: auto; display: block; margin: 0 auto;">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    @endif
</body>
</html>
