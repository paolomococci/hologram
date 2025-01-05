<div>
    <div class="flex relative flex-col bg-transparent rounded-xl">
        <h4 class="block text-xl font-medium text-green-600 dark:text-green-300">
            Login
        </h4>
        <p class="text-sm font-light text-slate-600 dark:text-slate-300">
            Nice to meet you! Enter your details to login.
        </p>
        <form class="mt-4 mb-2 w-80 max-w-screen-lg sm:w-96">
            <div class="flex flex-col gap-6 mb-1">
                <x-input.input-email />
                <x-input.input-password />
            </div>
            <div class="inline-flex items-center my-2">
                <x-checkbox.checkbox-remember-me />
            </div>
            <div class="w-full max-w-sm min-w-[100px]">
                <x-button.button-login />
                <p class="flex justify-center mt-6 text-sm text-slate-600 dark:text-slate-300">
                    Don't have an account yet?
                    <a href="/register" class="ml-1 text-sm font-semibold underline text-slate-600 dark:text-slate-300">
                        Request an account now.
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
