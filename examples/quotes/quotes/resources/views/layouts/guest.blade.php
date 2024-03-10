<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Quotes') }}</title>

    <!-- Favicon -->
    {{-- <link rel="shortcut icon" href="{{ env('APP_URL') }}favicon.ico" type="image/x-icon"> --}}
    {{-- <link rel="shortcut icon" href="{{ env('APP_URL') }}hologram.svg" type="image/svg+xml"> --}}
    <link rel="shortcut icon" href="{{ env('APP_URL') }}hologram.png" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Style -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}css/forms-style.css">
    <link rel="stylesheet" href="{{ env('APP_URL') }}css/icons-style.css">
    <link rel="stylesheet" href="{{ env('APP_URL') }}css/icons-logged-style.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div class="font-sans antialiased text-gray-900 dark:text-gray-100">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>
