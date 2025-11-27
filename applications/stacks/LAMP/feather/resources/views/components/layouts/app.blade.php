<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ $title ?? 'Somethings' }}</title>
</head>

<body
    class="bg-stone-300 dark:bg-stone-900 text-stone-500 dark:text-stone-300 flex p-4 sm:p-6 lg:p-8 items-center justify-center min-h-screen">

    {{-- header --}}
    <livewire:header>

        {{-- main --}}
        <div class="w-full flex items-center justify-center">
            <main
                class="flex w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-4xl flex-col-reverse lg:flex-row gap-4 sm:gap-6 lg:gap-8">
                {{ $slot }}
            </main>
        </div>
</body>

</html>
