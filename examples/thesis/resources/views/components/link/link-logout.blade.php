{{-- refer to it like this alias tag: <x-link.link-logout /> --}}
<div>
    <a href="{{ url('/logout') }}"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#bfa] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="text-green-600 dark:text-green-300 lucide lucide-log-out size-8 lg:size-10 sm:size-4">
            <title>logout</title>
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
            <polyline points="16 17 21 12 16 7" />
            <line x1="21" x2="9" y1="12" y2="12" />
        </svg>
    </a>
</div>
