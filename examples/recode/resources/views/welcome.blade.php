<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if (env('APP_NAME', 'Laravel') != 'Laravel')
        <title>{{ env('APP_NAME') }}</title>
    @else
        <title>Laravel</title>
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

        <div
            class="flex relative flex-col justify-center items-center min-h-screen selection:bg-cyan-500 selection:text-white">
            <div class="relative px-6 w-full max-w-2xl lg:max-w-7xl">
                <header class="grid grid-cols-2 gap-2 items-center py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-auto h-14 text-transparent lucide lucide-code lg:h-20 lg:text-cyan-300">
                            <polyline points="16 18 22 12 16 6" />
                            <polyline points="8 6 2 12 8 18" />
                        </svg>
                    </div>
                    @if (Route::has('login'))
                        <nav class="flex flex-1 justify-end -mx-3">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#20F0FF] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#20F0FF] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#20F0FF] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        {{-- docs-card --}}
                        <section id="docs-card"
                            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#20F0FF] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#20F0FF]">
                            {{-- screenshot-container --}}
                            <div id="screenshot-container" class="flex relative flex-1 items-stretch w-full">

                                <img class="object-none" src="images/Recode_request_query_sql.png" alt="query detail">
                                <div
                                    class="absolute -bottom-16 -left-16 h-40 w-[calc(100%+8rem)] bg-gradient-to-b from-transparent via-white to-white dark:via-zinc-900 dark:to-zinc-900">
                                </div>
                            </div>

                            {{-- docs-card-content --}}
                            <div class="flex relative gap-6 items-center lg:items-end">
                                <div id="docs-card-content" class="flex gap-6 items-start lg:flex-col">
                                    <div
                                        class="flex justify-center items-center rounded-full size-12 shrink-0 bg-cyan-500/10 sm:size-16">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="text-cyan-300 lucide lucide-book-open-text size-5 sm:size-6">
                                            <path d="M12 7v14" />
                                            <path d="M16 12h2" />
                                            <path d="M16 8h2" />
                                            <path
                                                d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                            <path d="M6 12h2" />
                                            <path d="M6 8h2" />
                                        </svg>
                                    </div>

                                    <livewire:llm.recode-documentation />

                                </div>

                                {{-- space for a possible svg --}}
                            </div>
                        </section>

                        {{-- query-card --}}
                        <section id="query-card"
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#20F0FF] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#20F0FF]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-cyan-500/10 sm:size-16">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-cyan-300 lucide lucide-circle-help size-5 sm:size-6">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                                    <path d="M12 17h.01" />
                                </svg>
                            </div>

                            <livewire:llm.recode-query />

                            {{-- space for a possible svg --}}
                        </section>

                        {{-- response-card --}}
                        <section id="response-card"
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#20F0FF] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#20F0FF]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-cyan-500/10 sm:size-16">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-cyan-300 lucide lucide-message-square-reply size-5 sm:size-6">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                    <path d="m10 7-3 3 3 3" />
                                    <path d="M17 13v-1a2 2 0 0 0-2-2H7" />
                                </svg>
                            </div>

                            <livewire:llm.recode-response />

                            {{-- space for a possible svg --}}
                        </section>

                        {{-- statistic-card --}}
                        <section id="statistic-card"
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#20F0FF] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#20F0FF]">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-cyan-500/10 sm:size-16">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="text-cyan-300 lucide lucide-chart-scatter size-5 sm:size-6">
                                    <circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
                                    <circle cx="18.5" cy="5.5" r=".5" fill="currentColor" />
                                    <circle cx="11.5" cy="11.5" r=".5" fill="currentColor" />
                                    <circle cx="7.5" cy="16.5" r=".5" fill="currentColor" />
                                    <circle cx="17.5" cy="14.5" r=".5" fill="currentColor" />
                                    <path d="M3 3v16a2 2 0 0 0 2 2h16" />
                                </svg>
                            </div>

                            <livewire:llm.recode-statistic />

                            {{-- space for a possible svg --}}
                        </section>
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
