<div>
    <div class="px-1 pt-3 pb-2 mx-3 mb-0 border-b border-slate-200">
        <h3 class="flex justify-center text-2xl font-semibold uppercase text-slate-800">
            catenaria
        </h3>
    </div>
    <form action="" method="POST">
        <fieldset class="flex flex-col gap-4 p-6">
            <legend class="text-sm text-slate-400">
                <span class="block">The email and password fields are mandatory.</span>
                <span class="block">A valid email.</span>
                <span class="block">
                    The password must be at least twelve lowercase and uppercase characters, must contain at least one a
                    number and a symbol.
                </span>
            </legend>
            <div class="flex justify-center mb-4">
                <x-carbon-login class="size-12 text-slate-800" />
            </div>
            <div class="w-full">
                <x-elements.input.email placeholder="enter a valid email" />
            </div>
            <div class="w-full">
                <x-elements.input.password placeholder="at least twelve characters" />
            </div>
            <div class="p-6 pt-0">
                <x-elements.button.text-button textLabel="login" />
                <p class="flex justify-center mt-6 text-sm text-slate-600">Request an account:
                    <a href="/register"
                        class="ml-1 text-sm font-semibold underline uppercase text-slate-800 hover:text-slate-600">
                        register
                    </a>
                </p>
            </div>
        </fieldset>
    </form>
</div>
