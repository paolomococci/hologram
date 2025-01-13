{{-- pseudo-tag: <x-elements.input.generic /> --}}
@props(['label', 'id', 'placeholder'])

<div>
    <label for="name" class="block mb-2 text-sm text-slate-600">
        {{ $label ?? 'Field' }}
    </label>
    <input type="text" id="{{ $id ?? 'field' }}"
        class="px-3 py-2 w-full text-sm bg-transparent rounded-md border shadow-sm transition duration-300 placeholder:text-slate-400 text-slate-700 border-slate-200 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 focus:shadow"
        placeholder="{{ $placeholder ?? 'generic field' }}" />
</div>
