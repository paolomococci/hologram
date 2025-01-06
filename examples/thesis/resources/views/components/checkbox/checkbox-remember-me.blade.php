{{-- refer to it like this alias tag: <x-checkbox.checkbox-remember-me /> --}}
@props(['rememberMe' => false])

<div>
    <label class="mr-4 mb-3 text-sm cursor-pointer text-slate-600 dark:text-slate-300" for="remember-me">
        <input id="remember-me" type="checkbox" value="bulletin_board"
            class="w-5 h-5 rounded border shadow transition-all appearance-none cursor-pointer peer hover:shadow-md border-slate-200 checked:border-slate-800 checked:bg-green-300 checked:dark:bg-green-600">
        Remember Me
    </label>
</div>
