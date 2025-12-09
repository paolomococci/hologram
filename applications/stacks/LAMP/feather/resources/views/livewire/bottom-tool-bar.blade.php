{{-- resources/views/livewire/bottom-tool-bar.blade.php --}}
<div class="fixed inset-x-0 bottom-4 start-4 flex justify-start">
    <div class="group">
        <div
            class="bg-stone-400 rounded-l-full rounded-r-full
                    transition-all duration-300 ease-in-out
                    w-12 lg:w-20 group-hover:w-full overflow-hidden flex items-center justify-evenly">

            <div class="flex-1 text-center">
                <livewire:fab-create />
            </div>

            <div class="flex-1 text-center">
                <livewire:fab-edit />
            </div>

            <div class="flex-1 text-center">
                <livewire:fab-done />
            </div>

            <div class="flex-1 text-center">
                <livewire:fab-todo />
            </div>

            <div class="flex-1 text-center">
                <livewire:fab-canceled />
            </div>

            <div class="flex-1 text-center">
                <livewire:toggle />
            </div>

        </div>
    </div>
</div>
