{{-- pseudo-tag: <x-elements.samp.show-errors /> --}}
@if ($errors->any())
    <div {{ $attributes }}>
        <samp class="m-4 text-red-800 dark:text-red-500 text-md">
            {{ __('Sorry, something went wrong?!') }}
        </samp>
        <samp class="mt-2">
            <ul class="list-none">
                @foreach ($errors->all() as $error)
                    <li class="p-1 m-1 w-2/3 text-sm text-orange-500 rounded-sm bg-slate-200">{{ $error }}</li>
                @endforeach
            </ul>
        </samp>
    </div>
@endif
