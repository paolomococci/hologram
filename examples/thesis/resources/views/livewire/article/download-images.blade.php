@php
    use App\Utils\CleaningUtility;
    // dd($articleForm->image_path);
@endphp

{{-- session status feedback with flash --}}
{{-- @if (session('status'))
    <div wire:key="{{ rand() }}">
        <div class="px-3 m-3 bg-green-200 rounded-sm dark:bg-green-700">
            <p class="text-green-700 dark:text-green-200">
                {{ session('status') }}
            </p>
        </div>
        <div class="m-4">
            <button type="button" class="inline p-2 text-cyan-200 bg-green-600 rounded-md hover:bg-green-600/50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-green-300 lucide lucide-refresh-ccw size-4 sm:size-3 lg:size-5">
                    <title>refresh</title>
                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                    <path d="M3 3v5h5" />
                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                    <path d="M16 16h5v5" />
                </svg>
            </button>
        </div>
    </div>
@endif --}}

<div class="mx-4">

    <x-alerts.offline />

    @if (count($uriImages) < 1)
        <div>
            <dl class="text-sm/relaxed text-slate-300/40 dark:text-slate-300">
                Sorry, there are no images associated with the article titled:</dl>
            <dt class="mb-4 text-md/relaxed text-green-300/40 dark:text-green-300">
                {{ CleaningUtility::cleanTitle($articleForm->article->title) }}
            </dt>
        </div>
    @else
        <div>
            <dl class="text-sm/relaxed text-slate-300/40 dark:text-slate-300">
                From here you can download the images related to the article entitled:</dl>
            <dt class="mb-4 text-md/relaxed text-green-300/40 dark:text-green-300">
                {{ CleaningUtility::cleanTitle($articleForm->article->title) }}
            </dt>
        </div>
        <div>
            <table class="mt-4">
                <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                    <tr class="text-slate-800 dark:text-slate-300">
                        <th class="px-3 py-2">Image</th>
                        <th class="px-3 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($uriImages as $uriImage)
                        <x-forms.downloadable-image uriImage="{{ $uriImage }}" />
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="m-4">
        <button type="button" class="inline p-2 text-cyan-200 bg-green-600 rounded-md hover:bg-green-600/50"
            wire:click="cancel()" wire:offline.attr="disabled">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="text-green-300 lucide lucide-undo-2 size-4 sm:size-3 lg:size-5">
                <title>cancel</title>
                <path d="M9 14 4 9l5-5" />
                <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
            </svg>
        </button>
    </div>
</div>
