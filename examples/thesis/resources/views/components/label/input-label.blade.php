{{-- for example refer to it like this alias tag: <x-label.input-label for="email" value="{{ __('Email') }}" /> --}}
@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-2 text-sm text-orange-600 dark:text-orange-300']) }}>
    {{ $value ?? $slot }}
</label>
