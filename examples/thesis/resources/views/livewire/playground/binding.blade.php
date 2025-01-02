<div>

    {{-- title of this component --}}
    <h2 class="text-xl font-semibold text-black dark:text-white">{{ $title }}</h2>

    {{-- explanation of this component --}}
    <p class="mt-4 text-sm/relaxed">
        {{ $explanation }}
    </p>

    <div x-data="{ firstAddend: 0, secondAddend: 0 }">
        <input class="block m-2 text-slate-700" type="text" x-model.number="firstAddend"> +
        <input class="block m-2 text-slate-700" type="text" x-model.number="secondAddend"> =
        <output class="p-4 m-4" x-text="firstAddend + secondAddend"></output>
    </div>

</div>
