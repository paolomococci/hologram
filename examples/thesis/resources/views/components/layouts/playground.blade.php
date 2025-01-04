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
    <style>
        .active {
            color: sienna;
            text-transform: uppercase;
        }

        .tab-wrap {
            border: 1px solid sienna;
            padding: 1rem;
            margin-top: 1rem;
        }
    </style>
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
                        {{-- grooved component: show-messages --}}
                        <div id="show-messages"
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 dark:text-green-300 lucide lucide-messages-square size-5 sm:size-4 lg:size-6">
                                    <title>messages</title>
                                    <path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2z" />
                                    <path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1" />
                                </svg>
                            </div>

                            <div>
                                <div class="pt-3 mt-4 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">Messages</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Learn about some of the types of messages you can use as feedback.
                                    </p>

                                    <div class="mx-2 my-3">
                                        {{ $slot }}
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- canvas-game --}}
                        <div id="canvas-game"
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 dark:text-green-300 lucide lucide-clipboard-x size-5 sm:size-4 lg:size-6">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                    <path
                                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    <path d="m15 11-6 6" />
                                    <path d="m9 11 6 6" />
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5">

                                <div class="mx-2 my-3">
                                    <livewire:playground.canvas title="Canvas"
                                        explanation="Try to match the couples of colored cards by remembering their positions." />
                                </div>
                            </div>
                        </div>

                        {{-- TODO: template row --}}

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 dark:text-green-300 lucide lucide-plus size-5 sm:size-4 lg:size-6">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                            </div>

                            {{-- data binding --}}
                            <div class="mx-2 my-3">
                                <div id="data-binding" class="pt-3 sm:pt-5">
                                    <livewire:playground.binding title="Addition"
                                        explanation="One-way data binding." />
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 dark:text-green-300 lucide lucide-toggle-left size-5 sm:size-4 lg:size-6">
                                    <rect width="20" height="12" x="2" y="6" rx="6" ry="6" />
                                    <circle cx="8" cy="12" r="2" />
                                </svg>
                            </div>

                            {{-- toggle --}}
                            <div class="mx-2 my-3">
                                <div id="toggle" class="pt-3 sm:pt-5">
                                    <livewire:playground.toggle title="Toggle"
                                        explanation="Example of toggle menu also obtained thanks to the styles." />
                                </div>
                            </div>
                        </div>

                        {{-- TODO: template row --}}

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 dark:text-green-300 lucide lucide-database-backup size-5 sm:size-4 lg:size-6">
                                    <ellipse cx="12" cy="5" rx="9" ry="3" />
                                    <path d="M3 12a9 3 0 0 0 5 2.69" />
                                    <path d="M21 9.3V5" />
                                    <path d="M3 5v14a9 3 0 0 0 6.47 2.88" />
                                    <path d="M12 12v4h4" />
                                    <path
                                        d="M13 20a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L12 16" />
                                </svg>
                            </div>

                            {{-- two way data binding --}}
                            <div class="mx-2 my-3">
                                <div id="two-way-data-binding" class="pt-3 sm:pt-5">
                                    <livewire:playground.two-way-binding title="Two way Data binding"
                                        explanation="Two-way data binding explanation…" />
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#bfa] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#bfa]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-green-600/30 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-green-600 dark:text-green-300 lucide lucide-box size-5 sm:size-4 lg:size-6">
                                    <path
                                        d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                    <path d="m3.3 7 8.7 5 8.7-5" />
                                    <path d="M12 22V12" />
                                </svg>
                            </div>

                            {{-- template right1 --}}
                            <div class="mx-2 my-3">
                                <div id="template-right1" class="pt-3 sm:pt-5">
                                    <livewire:playground.something title="Something"
                                        explanation="Something component explanation…" />
                                </div>
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
