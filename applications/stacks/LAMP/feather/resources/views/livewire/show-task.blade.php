{{-- resources/views/livewire/show-task.blade.php --}}
{{-- Blade template for ShowTask --}}
<div class="container px-4 py-4 mx-auto">
    {{-- The outer wrapper that holds everything, it uses Tailwind utility classes to set up a centered container --}}
    <div class="absolute top-[20%] md:top-1/5 inset-x-0 w-full">
        <div class="flex justify-center items-center w-full">
            <div
                class="px-4 py-2 mx-auto w-full max-w-xs text-center rounded-md sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl text-stone-600 dark:text-stone-400 bg-stone-200 dark:bg-stone-700">
                {{-- before the main content --}}
                @if (session('success'))
                    {{-- <div class="p-4 mb-4 text-green-800 bg-green-100 rounded">
                        {{ session('success') }}
                    </div> --}}
                    <livewire:feedback message="{{ session('success') }}" type="success" />
                @endif
                <div class="flex items-center w-full">
                    {{-- button on the left that points to the previous task --}}
                    <button wire:click="prev"
                        class="flex shrink-0 m-1.5 p-1.5 rounded-l-full hover:bg-green-300 {{ $this->task->id == $this->minId ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $this->task->id == $this->minId ? 'disabled' : '' }}>
                        <x-glyph name="chevron-left" title="To go to the previous task" />
                    </button>

                    {{-- central text with the task fields --}}
                    <div class="flex-1 text-center">
                        <code class="text-xl lg:text-2xl text-stone-50 dark:text-stone-800">{{ $task->id }}</code>
                        <h2 class="text-2xl lg:text-4xl text-stone-600 dark:text-stone-100">{{ $task->tag }}</h2>
                        <p class="text-sm lg:text-lg text-stone-700 dark:text-stone-300">
                            {{ $task->description }}
                        </p>
                    </div>

                    {{-- button on the right that points to the next task --}}
                    <button wire:click="next"
                        class="flex shrink-0 m-1.5 p-1.5 rounded-r-full hover:bg-green-300 {{ $this->task->id == $this->maxId ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $this->task->id == $this->maxId ? 'disabled' : '' }}>
                        <x-glyph name="chevron-right" title="To go to the next task" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    console.log("Identifier of the initially selected Task: {{ $task->id }}")
    console.log("Tag of the initially selected task: {{ $task->tag }}")
    console.log("Description of the initially selected task: {{ $task->description }}")
    console.log("This task is done: {{ $task->is_done ? 'true' : 'false' }}")
</script>
