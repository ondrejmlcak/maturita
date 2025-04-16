<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ config('app.name', 'Laravel') }}</h1>
        <div class="mt-2 space-x-4">
            @if (Route::currentRouteName() !== 'verification.notice')
                <div class="mt-2 space-x-4">
                    @if (Route::currentRouteName() === 'register')
                        <p class="text-sm text-gray-600 mt-1">Už máš účet?</p>
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Přihlášení</a>
                    @elseif (Route::currentRouteName() === 'login')
                        <p class="text-sm text-gray-600 mt-1">Ještě nemáš účet?</p>
                        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Registrace</a>
                    @endif
                </div>
            @endif

        </div>

    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-200 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
</body>
</html>
