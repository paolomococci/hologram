{{-- pseudo-tag: <x-elements.button.text-button /> --}}
@props(['textLabel'])

<div>
    <button
        class="px-4 py-2 w-full text-sm text-center text-white uppercase rounded-full border border-transparent shadow-md transition-all bg-slate-800 hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
        type="button">
        {{ $textLabel }}
    </button>
</div>
