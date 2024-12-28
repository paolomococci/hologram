<div>
    {{-- session status feedback with flash --}}
    @if (session('status'))
        <div wire:key="{{ rand() }}">
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="px-3 m-3 bg-green-200 rounded-sm dark:bg-green-700">
                <p class="text-green-700 dark:text-green-200">
                    {{ session('status') }}
                </p>
            </div>
        </div>
    @endif
    <livewire:article.catalog />
</div>
