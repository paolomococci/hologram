<div
    class="dashboard-head">

    <h1 class="app-h1-grey">
        Editor of author information
    </h1>

    <p class="app-paragraph-grey">
        Here the author's are entered into the system, listed and, when necessary, the data concerning them is modified.
    </p>
</div>

<div class="dashboard-grid">
    <div>
        <div class="flex items-center">
            <i class="bi bi-archive icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                <a href="#">Record</a>
            </h2>
        </div>

        <p class="paragraph-grey">
            Register a new author's details before he or she can start writing and commenting on other people's
            articles.
        </p>

        <div class="mt-4 text-sm">
            <livewire:author.create-author />
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-list-ul icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                <a href="#">List</a>
            </h2>
        </div>

        <p class="paragraph-grey">
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
