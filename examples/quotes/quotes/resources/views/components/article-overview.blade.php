<div
    class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">

    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        Editor of information and article content
    </h1>

    <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
        Here the article's are entered into the system, listed and, when necessary, the data concerning them is
        modified.
    </p>
</div>

<div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
    <div>
        <div class="flex items-center">
            <i class="bi bi-archive icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                Record
            </h2>
        </div>

        <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            Inserts a new article into the system, allowing you to edit its content at the same time.
        </p>
        <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            Please be careful, all fields are required.
            The first two range from a minimum of ten to a maximum of two hundred and fifty-five characters.
            The third field requires a minimum of ten characters.
            The last field requires a minimum of twenty characters.
            But the most important thing is that the title must be unique.
            Thanks for the attention.
        </p>

        <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            <livewire:article.create-article />
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-list-ul icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                List
            </h2>
        </div>

        <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            To access an article's data you need to click on the link of interest.
        </div>

        <div class="mt-4 text-sm">
            <livewire:article.overview-articles />
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-1 lg:gap-8 lg:p-8">
    <livewire:article.read-article />
</div>

<div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-1 lg:gap-8 lg:p-8">
    <livewire:article.update-article />
</div>
