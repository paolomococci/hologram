{{-- resources/views/livewire/task.blade.php --}}
{{-- Currently unused component. --}}
<div class="container mx-auto px-4 py-4">
    <div class="absolute top-[20%] md:top-1/5 inset-x-0 w-full">
        <div class="flex justify-center items-center w-full">
            <div
                class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl text-stone-600 dark:text-stone-400 bg-stone-200 dark:bg-stone-700 px-4 py-2 rounded-md text-center mx-auto">
                <div class="flex items-center w-full">
                    {{-- Left button. --}}
                    <button class="flex shrink-0 p-1.5 rounded-l-sm hover:bg-green-300">
                        <x-glyph name="chevron-left" title="To go to the previous task" />
                    </button>

                    {{-- Centered text, or the space occupied between the buttons. --}}
                    <div class="flex-1 text-center">
                        <h2 class="text-2xl text-white">{{ $task->tag }}</h2>
                        <div class="mt-4">
                            {{ $task->description }}
                        </div>
                    </div>

                    {{-- Right button. --}}
                    <button class="flex shrink-0 p-1.5 rounded-r-sm hover:bg-green-300">
                        <x-glyph name="chevron-right" title="To go to the next task" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
