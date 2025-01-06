<div>

    <div class="flex relative flex-col bg-transparent rounded-xl">
        <h4 class="block text-xl font-medium text-green-600 dark:text-green-300">
            Register
        </h4>
        <p class="text-sm font-light text-slate-600 dark:text-slate-300">
            Nice to meet you! Enter your details to sig up.
        </p>
        <form method="POST" wire:submit="registerAnApplicant" class="mt-4 mb-2 w-80 max-w-screen-lg sm:w-96">
            @csrf
            <div class="flex flex-col gap-6 mb-1">
                {{-- <x-input.input-name wire:model="name" /> --}}
                <div class="w-full max-w-sm min-w-[100px]">
                    <label class="block mb-2 text-sm text-orange-600 dark:text-orange-300">
                        Your Name
                    </label>
                    <input type="text" wire:model="name"
                        class="px-3 py-2 w-full text-sm bg-transparent rounded-md border border-orange-600 shadow-sm transition duration-300 dark:border-orange-300 placeholder:text-slate-400 text-slate-700 dark:text-slate-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 focus:shadow"
                        placeholder="Your Name" />
                </div>
                <div>
                    @error('name')
                        <span class="text-red-600">{{ $registerMessage }}</span>
                    @enderror
                </div>
                {{-- <x-input.input-email wire:model="email" /> --}}
                <div class="w-full max-w-sm min-w-[100px]">
                    <label class="block mb-2 text-sm text-orange-600 dark:text-orange-300">
                        Email
                    </label>
                    <input type="email" wire:model="email"
                        class="px-3 py-2 w-full text-sm bg-transparent rounded-md border border-orange-600 shadow-sm transition duration-300 dark:border-orange-300 placeholder:text-slate-400 text-slate-700 dark:text-slate-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 focus:shadow"
                        placeholder="Your Email" />
                </div>
                <div>
                    @error('email')
                        <span class="text-red-600">{{ $registerMessage }}</span>
                    @enderror
                </div>
                {{-- <x-input.input-password wire:model="password" /> --}}
                <div class="w-full max-w-sm min-w-[100px]">
                    <label class="block mb-2 text-sm text-orange-600 dark:text-orange-300">
                        Password
                    </label>
                    <input type="password" wire:model="password"
                        class="px-3 py-2 w-full text-sm bg-transparent rounded-md border border-orange-600 shadow-sm transition duration-300 dark:border-orange-300 placeholder:text-slate-400 text-slate-700 dark:text-slate-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 focus:shadow"
                        placeholder="Your Password" />
                </div>
                <div>
                    @error('password')
                        <span class="text-red-600">{{ $registerMessage }}</span>
                    @enderror
                </div>
            </div>
            <div class="inline-flex items-center my-2">
                {{-- <x-checkbox.checkbox-remember-me wire:model="rememberMe" /> --}}
                <label class="mr-4 mb-3 text-sm cursor-pointer text-slate-600 dark:text-slate-300" for="remember-me">
                    <input id="remember-me" type="checkbox" value="bulletin_board" wire:model="rememberMe"
                        class="w-5 h-5 rounded border shadow transition-all appearance-none cursor-pointer peer hover:shadow-md border-slate-200 checked:border-slate-800 checked:bg-green-300 checked:dark:bg-green-600">
                    Remember Me
                </label>
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
