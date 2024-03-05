<div
    class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">

    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        Editor of author information
    </h1>

    <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
        Here are some useful tools to maintain data consistency.
    </p>
</div>

<div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
    <div>
        <div class="flex items-center">
            <i class="bi bi-list-ol icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                <a href="#">Renumber</a>
            </h2>
        </div>

        <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            Tool that regenerates the numerical identifiers of the table that maintains the correlations between the
            author and the article he contributed to writing.
        </p>

        <p class="mt-4 text-sm">
            <livewire:contributor.renumber-contrib />
        </p>
    </div>

    {{-- <div>
        <div class="flex items-center">
            <i class="bi bi-list-ul icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                <a href="#">TODO: some title of tool</a>
            </h2>
        </div>

        <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            TODO: some explanatory text
        </p>

        <p class="mt-4 text-sm">
            TODO: some injected component
        </p>
    </div> --}}
</div>
