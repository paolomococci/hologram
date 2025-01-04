<div>

    {{-- title of this component --}}
    <h2 class="text-xl font-semibold text-black dark:text-white">{{ $title }}</h2>

    {{-- content of this component --}}
    <p class="mt-4 text-sm/relaxed">
        {{ $content }}
    </p>

    <div class="p-4 m-4">
        <x-accordions.icon-toggle jsonDataItems="{{ $jsonDataItems }}" />
    </div>

</div>
