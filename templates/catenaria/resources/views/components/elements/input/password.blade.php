{{-- pseudo-tag: <x-elements.input.password /> --}}
@props(['placeholder'])

<div>
    <label for="password" class="block mb-2 text-sm text-slate-600"
        title="at least twelve lowercase and uppercase characters, a number and a symbol">
        Password
    </label>
    <input type="password" id="password"
        class="px-3 py-2 w-full text-sm bg-transparent rounded-sm border shadow-sm transition duration-300 placeholder:text-slate-400 text-slate-700 border-slate-200 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 focus:shadow"
        placeholder="{{ $placeholder ?? 'your strong password' }}" />
</div>
