<div>
    <div class="px-1 pt-3 pb-2 mx-3 mb-0 border-b border-slate-200">
        <h3 class="flex justify-center text-2xl font-semibold uppercase text-slate-800">
            catenaria
        </h3>
    </div>
    <x-elements.samp.show-errors />
    <form wire:submit="registration" method="POST">
        @csrf
        <fieldset class="flex flex-col gap-4 p-6">
            <legend class="text-sm text-slate-400">
                <span class="block">The name, email and password fields are mandatory.</span>
                <span>The name field must be at least three characters long.</span>
                <span class="block">A valid email.</span>
                <span class="block">
                    The password must be at least twelve lowercase and uppercase characters, must contain at least one a
                    number and a symbol.
                </span>
            </legend>
            <div class="flex justify-center mb-4">
                <x-carbon-user-profile class="size-12 text-slate-800" />
            </div>
            <div class="w-full">
                <x-elements.input.name wire:model="name" />
            </div>
            <div class="w-full">
                <x-elements.input.email wire:model="email" />
            </div>
            <div class="w-full">
                <x-elements.input.password wire:model="password" />
            </div>
            <div class="p-6 pt-0">
                <x-elements.button.text-button textLabel="login" />
                <p class="flex justify-center mt-6 text-sm text-slate-600">Already have an account?
                    <a href="/login"
                        class="ml-1 text-sm font-semibold underline uppercase text-slate-800 hover:text-slate-600">
                        login
                    </a>
                </p>
            </div>
        </fieldset>
    </form>
</div>
