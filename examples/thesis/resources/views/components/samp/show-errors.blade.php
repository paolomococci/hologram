{{-- for example refer to it like this alias tag: <x-samp.show-errors /> --}}
@if ($errors->any())
    <div {{ $attributes }}>
        <samp class="m-4 text-red-800 dark:text-red-500 text-md">
            {{ __('Sorry, something went wrong?!') }}
        </samp>
        <samp class="mt-2">
            <ul class="list-none">
                @foreach ($errors->all() as $error)
                    <li class="p-1 m-1 w-2/3 text-sm text-red-800 rounded-sm dark:text-red-500 bg-slate-200">{{ $error }}</li>
                @endforeach
            </ul>
        </samp>
    </div>
@endif
