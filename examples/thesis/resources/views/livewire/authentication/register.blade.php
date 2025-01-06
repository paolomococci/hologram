<div>

    <div class="flex relative flex-col bg-transparent rounded-xl">
        <h4 class="block text-xl font-medium text-green-600 dark:text-green-300">
            Register
        </h4>
        <p class="text-sm font-light text-slate-600 dark:text-slate-300">
            Nice to meet you! Enter your details to sig up.
        </p>
        <x-samp.show-errors />
        <form method="POST" wire:submit="registerAnApplicant" class="mt-4 mb-2 w-80 max-w-screen-lg sm:w-96">
            @csrf
            <div class="flex flex-col gap-6 mb-1">
                <x-input.input-name wire:model="name" />
                <x-input.input-email wire:model="email" />
                <x-input.input-password wire:model="password" />
            </div>
            <div class="inline-flex items-center my-2">
                <x-checkbox.checkbox-remember-me :disabled="true" wire:model="rememberMe" />
            </div>
            <div class="w-full max-w-sm min-w-[100px]">
                <x-button.button-registration />
                <p class="flex justify-center mt-6 text-sm text-slate-600 dark:text-slate-300">
                    Do you already have a valid account?
                    <a href="/login" class="ml-1 text-sm font-semibold underline text-slate-600 dark:text-slate-300">
                        Feel free to use it.
                    </a>
                </p>
            </div>
        </form>
    </div>

</div>
