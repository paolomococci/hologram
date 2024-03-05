<div
    class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">

    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        Editor of author information
    </h1>

    <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
        Here the author's are entered into the system, listed and, when necessary, the data concerning them is modified.
    </p>
</div>

<div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
    <div>
        <div class="flex items-center">
            <i class="bi bi-archive icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                <a href="#">Record</a>
            </h2>
        </div>

        <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            Register a new author's details before he or she can start writing and commenting on other people's
            articles.
        </p>

        <p class="mt-4 text-sm">
            <livewire:author.create-author />
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-list-ul icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                <a href="#">List</a>
            </h2>
        </div>

        <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            To access an author's data you need to click on the link of interest.
        </p>

        <p class="mt-4 text-sm">
            <livewire:author.overview-authors />
        </p>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-1 lg:gap-8 lg:p-8">
    <livewire:author.read-author />
</div>

<div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-1 lg:gap-8 lg:p-8">
    <livewire:author.update-author />
</div>
