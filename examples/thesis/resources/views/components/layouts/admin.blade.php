<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>dashboard</title>

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
        <pre>
            {{-- {{ var_dump($_SERVER) }} --}}
        </pre>
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
                                {{-- name of logged user --}}
                                <div>
                                    <span class="inline-block px-4 mx-4">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <x-link.link-logout />
                                </div>
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
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 dark:text-green-300 lucide lucide-filter size-5 sm:size-4 lg:size-6">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Filter</h2>

                                <livewire:article.filter placeholder="text to filter between titles" />
                            </div>
                        </div>
                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <a {{-- href="/dashboard/article/create"  --}} href="{{ route('dashboard.article.create') }}" title="create a new article"
                                wire:navigate
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 dark:text-green-300 lucide lucide-newspaper size-5 sm:size-4 lg:size-6">
                                    <path
                                        d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2" />
                                    <path d="M18 14h-8" />
                                    <path d="M15 18h-5" />
                                    <path d="M10 6h8v4h-8V6Z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 -translate-y-3 dark:text-green-300 lucide lucide-plus size-3 sm:size-2 lg:size-4">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                            </a>

                            <div class="pt-3 sm:pt-5">
                                <h2 class="text-xl font-semibold text-black dark:text-white">Articles</h2>

                                {{ $slot }}

                                <p class="mt-4 text-sm/relaxed">
                                    <a href="{{ URL::previous() }}" title="go back" class="inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="text-green-600 dark:text-green-300 lucide lucide-circle-chevron-left size-5 sm:size-4 lg:size-6">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="m14 16-4-4 4-4" />
                                        </svg>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-sm text-center text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) - logged user:
                    <?= Auth::user()->name ?>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>
