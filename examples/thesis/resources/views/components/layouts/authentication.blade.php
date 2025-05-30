<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $title = env('APP_NAME') . ' ' . env('APP_VERSION');
    @endphp
    <title>{{ $title ?? 'Page Title' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50" x-data
    x-on:click="$dispatch('search:clear-results')">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        {{-- TODO: svg background image --}}
        <div
            class="flex relative flex-col justify-center items-center min-h-screen selection:bg-green-500 selection:text-white">
            <div class="relative px-6 w-full max-w-2xl lg:max-w-7xl">
                <header class="grid grid-cols-2 gap-2 items-center py-10 lg:grid-cols-3">
                    <a href="/" class="flex lg:justify-center lg:col-start-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-green-800 lucide lucide-notebook-text size-12 lg:size-16 sm:size-8">
                            <path d="M2 6h4" />
                            <path d="M2 10h4" />
                            <path d="M2 14h4" />
                            <path d="M2 18h4" />
                            <rect width="16" height="20" x="4" y="2" rx="2" />
                            <path d="M9.5 8h5" />
                            <path d="M9.5 12H16" />
                            <path d="M9.5 16H14" />
                        </svg>
                    </a>
                    @if (Route::has('login'))
                        <nav class="flex flex-1 justify-end -mx-3">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#bfa] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="text-green-600 dark:text-green-300 lucide lucide-layout-dashboard size-8 lg:size-10 sm:size-4">
                                        <title>dashboard</title>
                                        <rect width="7" height="9" x="3" y="3" rx="1" />
                                        <rect width="7" height="5" x="14" y="3" rx="1" />
                                        <rect width="7" height="9" x="14" y="12" rx="1" />
                                        <rect width="7" height="5" x="3" y="16" rx="1" />
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#bfa] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="text-green-600 dark:text-green-300 lucide lucide-log-in size-8 lg:size-10 sm:size-4">
                                        <title>login</title>
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                        <polyline points="10 17 15 12 10 7" />
                                        <line x1="15" x2="3" y1="12" y2="12" />
                                    </svg>
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#bfa] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="text-green-600 dark:text-green-300 lucide lucide-notebook-pen size-8 lg:size-10 sm:size-4">
                                            <title>register</title>
                                            <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4" />
                                            <path d="M2 6h4" />
                                            <path d="M2 10h4" />
                                            <path d="M2 14h4" />
                                            <path d="M2 18h4" />
                                            <path
                                                d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                        </svg>
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div
                            class="flex col-span-full items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-green-600 dark:text-green-300 lucide lucide-scan-eye size-5 sm:size-4 lg:size-6">
                                    <title>credentials</title>
                                    <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                    <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                    <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                    <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                    <circle cx="12" cy="12" r="1" />
                                    <path
                                        d="M18.944 12.33a1 1 0 0 0 0-.66 7.5 7.5 0 0 0-13.888 0 1 1 0 0 0 0 .66 7.5 7.5 0 0 0 13.888 0" />
                                </svg>
                            </div>

                            <div class="pt-3 w-full sm:pt-5">

                                {{-- livewire.authentication.login --}}
                                {{-- livewire.authentication.register --}}
                                {{ $slot }}

                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-sm text-center text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </div>
</body>

</html>
