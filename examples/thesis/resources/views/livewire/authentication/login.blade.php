<div>

    <div class="flex relative flex-col bg-transparent rounded-xl">
        <h4 class="block text-xl font-medium text-green-600 dark:text-green-300">
            Login
        </h4>
        <p class="text-sm font-light text-slate-600 dark:text-slate-300">
            Nice to meet you! Enter your details to login.
        </p>
        <x-samp.show-errors />
        <form method="POST" wire:submit="authentication" class="mt-4 mb-2 w-80 max-w-screen-lg sm:w-96">
            @csrf
            <div class="flex flex-col gap-6 mb-1">
                {{-- <x-input.input-email wire:model="email" /> --}}
                <div class="w-full max-w-sm min-w-[100px]">
                    <x-label.input-label for="email" value="{{ __('Email') }}" />
                    <input id="email" type="email" wire:model="email"
                        class="px-3 py-2 w-full text-sm bg-transparent rounded-md border border-orange-600 shadow-sm transition duration-300 dark:border-orange-300 placeholder:text-slate-400 text-slate-700 dark:text-slate-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 focus:shadow"
                        placeholder="Your Email" />
                </div>
                {{-- <x-input.input-password wire:model="password" /> --}}
                <div class="w-full max-w-sm min-w-[100px]">
                    <x-label.input-label for="password" value="{{ __('Password') }}" />
                    <input id="password" type="password" wire:model="password"
                        class="px-3 py-2 w-full text-sm bg-transparent rounded-md border border-orange-600 shadow-sm transition duration-300 dark:border-orange-300 placeholder:text-slate-400 text-slate-700 dark:text-slate-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 focus:shadow"
                        placeholder="Your Password" />
                </div>
            </div>
            <div class="inline-flex items-center my-2">
                {{-- <x-checkbox.checkbox-remember-me :value="old('rememberMe')" /> --}}
                <input id="rememberMe" type="checkbox" value="bulletin_board" wire:model="rememberMe"
                    class="w-5 h-5 rounded border shadow transition-all appearance-none cursor-pointer peer hover:shadow-md border-slate-200 checked:border-slate-800 checked:bg-green-300 checked:dark:bg-green-600">
                <x-label.input-label for="rememberMe" value="{{ __('Remember Me') }}" class="ml-2" />
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
