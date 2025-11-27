{{-- Blade template for ShowTask --}}
<div class="container px-4 py-4 mx-auto">
    {{-- The outer wrapper that holds everything, it uses Tailwind utility classes to set up a centered container --}}
    <div class="absolute top-[20%] md:top-1/5 inset-x-0 w-full">
        <div class="flex justify-center items-center w-full">
            <div
                class="px-4 py-2 mx-auto w-full max-w-xs text-center rounded-md sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl text-stone-600 dark:text-stone-400 bg-stone-200 dark:bg-stone-700">
                <div class="flex items-center w-full">
                    {{-- button on the left that points to the previous task --}}
                    <button wire:click="prev"
                        class="flex shrink-0 m-1.5 p-1.5 rounded-l-full hover:bg-green-300 {{ $this->task->id == $this->minId ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $this->task->id == $this->minId ? 'disabled' : '' }}>
                        {{-- remember to replace the icon_name placeholder with the correct name of your SVG file --}}
                        <x-glyph name="icon_name" title="To go to the previous task" />
                    </button>

                    {{-- central text with the task fields --}}
                    <div class="flex-1 text-center">
                        <h2 class="text-2xl text-stone-600 dark:text-stone-100">{{ $task->tag }}</h2>
                        <p class="text-sm text-stone-700 dark:text-stone-300">
                            {{ $task->description }}
                        </p>
                    </div>

                    {{-- button on the right that points to the next task --}}
                    <button wire:click="next"
                        class="flex shrink-0 m-1.5 p-1.5 rounded-r-full hover:bg-green-300 {{ $this->task->id == $this->maxId ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $this->task->id == $this->maxId ? 'disabled' : '' }}>
                        {{-- remember to replace the icon_name placeholder with the correct name of your SVG file --}}
                        <x-glyph name="icon_name" title="To go to the next task" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
