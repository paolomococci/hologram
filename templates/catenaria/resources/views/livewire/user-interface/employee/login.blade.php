<div>
    <div class="px-1 pt-3 pb-2 mx-3 mb-0 border-b border-slate-200">
        <h3 class="flex justify-center text-2xl font-semibold uppercase text-slate-800">
            catenaria
        </h3>
    </div>
    <div class="flex flex-col gap-4 p-6">
        <div class="flex justify-center mb-4">
            <x-carbon-login class="size-12 text-slate-800" />
        </div>
        <div class="w-full max-w-sm min-w-[200px]">
            <x-elements.input.email />
        </div>
        <div class="w-full max-w-sm min-w-[200px]">
            <x-elements.input.password />
        </div>
        <div class="p-6 pt-0">
            <x-elements.button.text-button textLabel="login" />
            <p class="flex justify-center mt-6 text-sm text-slate-600">Request an account:
                <a href="#register"
                    class="ml-1 text-sm font-semibold underline uppercase text-slate-800 hover:text-slate-600">
                    register
                </a>
            </p>
        </div>
    </div>
</div>
