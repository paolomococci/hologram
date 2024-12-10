<div class="pt-3 sm:pt-5">
    <h2 class="text-xl font-semibold text-black dark:text-white">Query</h2>

    <div class="mt-4 w-full text-sm/relaxed">
        <textarea wire:model.live.debounce="query"
            class="my-0 mt-4 w-full rounded-lg border-4 border-double border-slate-400 text-slate-800 focus:border-cyan-300"
            name="textarea-query" id="textarea-query" cols="40" rows="10"></textarea>

        <div class="flex w-full">
            <button wire:click="clear()" {{ empty($query) ? 'disabled' : '' }}
                class="flex justify-center items-center p-2 mt-2 mr-1 w-1/2 bg-cyan-300 rounded-l-lg hover:shadow-sm hover:shadow-cyan-100 disabled:shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-cyan-900 lucide lucide-message-square-off">
                    <title>clear</title>
                    <path d="M21 15V5a2 2 0 0 0-2-2H9" />
                    <path d="m2 2 20 20" />
                    <path d="M3.6 3.6c-.4.3-.6.8-.6 1.4v16l4-4h10" />
                </svg>
            </button>
            <button wire:click="submitQuery()" {{ empty($query) || $queryInProgress ? 'disabled' : '' }}
                class="flex justify-center items-center p-2 mt-2 ml-1 w-1/2 bg-cyan-300 rounded-r-lg hover:shadow-sm hover:shadow-cyan-100 disabled:shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-cyan-900 lucide lucide-send">
                    <title>send</title>
                    <path
                        d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                    <path d="m21.854 2.147-10.94 10.939" />
                </svg>
            </button>
        </div>
    </div>
</div>
