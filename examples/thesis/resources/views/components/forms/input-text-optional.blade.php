@props(['name'])

<div>
    <input
        class="p-2 w-full h-full align-text-top rounded-sm border text-start text-slate-300 bg-slate-600"
        type="text" name="{{ $name }}" {{ $attributes }}>
    <div>
        @error($name)
            <span class="mt-2 text-red-500 transition-opacity delay-500">{{ $message }}</span>
        @enderror
    </div>
</div>
