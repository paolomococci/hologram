@props(['uriImage'])

<tr class="border-b-2 border-green-100 bg-slate-800">
    <td class="py-2 pl-2">
        <img src="/storage/{{ $uriImage }}" alt="/storage/{{ $uriImage }}">
    </td>
    <td class="py-2 pl-3">
        <button type="button" class="inline p-2 text-cyan-200 bg-cyan-600 rounded-md hover:bg-cyan-600/50"
            wire:click="downloadImages('{{ $uriImage }}')" wire:confirm="Do you really want to download this image?"
            wire:offline.attr="disabled">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="text-cyan-300 lucide lucide-download size-4 sm:size-3 lg:size-5">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <polyline points="7 10 12 15 17 10" />
                <line x1="12" x2="12" y1="15" y2="3" />
            </svg>
        </button>
    </td>
</tr>
