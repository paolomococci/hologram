<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} {{ env('APP_VERSION') }}</title>

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
        {{-- Background image or path --}}
        <div
            class="flex relative flex-col justify-center items-center min-h-screen selection:bg-indigo-500 selection:text-white">
            <div class="relative px-6 w-full max-w-2xl lg:max-w-7xl">
                <header class="grid grid-cols-2 gap-2 items-center py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2">
                        <x-application-logo />
                        <h1 class="ml-4 text-2xl text-indigo-500">{{ env('APP_NAME') }} {{ env('APP_VERSION') }}</h1>
                    </div>
                    @if (Route::has('login'))
                        <nav class="flex flex-1 justify-end -mx-3">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="px-3 py-2 text-black rounded-md ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-purple-500 dark:text-indigo-300 dark:hover:text-indigo-500 dark:focus-visible:ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-layout-dashboard size-12">
                                        <title>dashboard</title>
                                        <rect width="7" height="9" x="3" y="3" rx="1" />
                                        <rect width="7" height="5" x="14" y="3" rx="1" />
                                        <rect width="7" height="9" x="14" y="12" rx="1" />
                                        <rect width="7" height="5" x="3" y="16" rx="1" />
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="px-3 py-2 text-black rounded-md ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-purple-500 dark:text-indigo-300 dark:hover:text-indigo-500 dark:focus-visible:ring-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-in size-12">
                                        <title>login</title>
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                        <polyline points="10 17 15 12 10 7" />
                                        <line x1="15" x2="3" y1="12" y2="12" />
                                    </svg>
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="px-3 py-2 text-black rounded-md ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-purple-500 dark:text-indigo-300 dark:hover:text-indigo-500 dark:focus-visible:ring-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-rectangle-ellipsis size-12">
                                            <title>registration</title>
                                            <rect width="20" height="12" x="2" y="6" rx="2" />
                                            <path d="M12 12h.01" />
                                            <path d="M17 12h.01" />
                                            <path d="M7 12h.01" />
                                        </svg>
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="mt-6">
                    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                        <div id="articles-card"
                            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-purple-500 md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-purple-500">

                            <div class="flex relative gap-6 items-center lg:items-end">
                                <div id="articles-card-content" class="flex gap-6 items-start lg:flex-col">
                                    <div
                                        class="flex justify-center items-center rounded-full size-12 shrink-0 bg-indigo-500/10 sm:size-16">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-clipboard-list size-10">
                                            <title>list of articles</title>
                                            <rect width="8" height="4" x="8" y="2" rx="1"
                                                ry="1" />
                                            <path
                                                d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                            <path d="M12 11h4" />
                                            <path d="M12 16h4" />
                                            <path d="M8 11h.01" />
                                            <path d="M8 16h.01" />
                                        </svg>
                                    </div>

                                    <div class="pt-3 sm:pt-5 lg:pt-0">

                                        @livewire('article.article-list')
                                        {{-- <livewire:article.article-list /> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-purple-500 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-purple-500">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-indigo-500/10 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-search size-10">
                                    <title>search</title>
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5">

                                @livewire('article.article-search')
                                {{-- <livewire:article.article-search /> --}}

                            </div>
                        </div>

                        <a href="#"
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-purple-500 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-purple-500">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-indigo-500/10 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-newspaper size-10">
                                    <title>highlighted article</title>
                                    <path
                                        d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2" />
                                    <path d="M18 14h-8" />
                                    <path d="M15 18h-5" />
                                    <path d="M10 6h8v4h-8V6Z" />
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5">

                                @livewire('article.article-read')

                            </div>
                        </a>

                        <div
                            class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-purple-500 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-purple-500">
                            <div
                                class="flex justify-center items-center rounded-full size-12 shrink-0 bg-indigo-500/10 sm:size-16">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-square-asterisk size-10">
                                    <title>article statistics</title>
                                    <rect width="18" height="18" x="3" y="3" rx="2" />
                                    <path d="M12 8v8" />
                                    <path d="m8.5 14 7-4" />
                                    <path d="m8.5 10 7 4" />
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5">

                                @livewire('article.article-stats')

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
