{{-- refer to it like this alias tag: <x-input.input-email /> --}}
@props(['disabled' => false])

<div>
    <div class="w-full max-w-sm min-w-[100px]">
        <label class="block mb-2 text-sm text-orange-600 dark:text-orange-300">
            Email
        </label>
        <input type="email" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' =>
                'px-3 py-2 w-full text-sm bg-transparent rounded-md border border-orange-600 shadow-sm transition duration-300 dark:border-orange-300 placeholder:text-slate-400 text-slate-700 dark:text-slate-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 focus:shadow',
        ]) !!} placeholder="Your Email" />
    </div>
</div>
