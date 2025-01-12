{{-- <livewire:user-interface.catenaria.welcome  /> --}}
<div>
    <div
        class="flex relative flex-col justify-center items-center p-2 my-6 w-full min-h-screen rounded-lg border shadow-sm transition-shadow duration-500 bg-slate-50 border-slate-200 hover:shadow-lg">
        <div class="px-1 pt-3 pb-2 mx-3 mb-0 border-b border-slate-200">
            <h5 class="text-sm font-medium text-slate-600">
                your supply chain at the tip of your fingers
            </h5>
        </div>
        <div class="p-3 text-center">
            <div class="flex justify-center mb-4">
                <x-carbon-task class="size-12 text-slate-800" />
            </div>
            <div class="flex justify-center mb-2">
                <h3 class="text-2xl font-semibold uppercase text-slate-800">
                    Catenaria
                </h3>
            </div>
            <div class="flex justify-center mb-2">
                <h5 class="text-xl font-semibold text-slate-500">
                    Managing your supply chain has never been easier.
                </h5>
            </div>
            <p class="block mb-4 max-w-lg font-light leading-normal text-slate-600">
                Start by logging in, and if you don't have an account yet, request one.
            </p>
            <div class="text-center">
                <a href="#"
                    class="flex items-center mr-2 text-sm font-semibold uppercase text-slate-800 hover:underline">
                    Go to login
                    <span><x-carbon-arrow-right class="size-5 text-slate-700" /></span>
                </a>
            </div>
        </div>
    </div>
</div>
