<div
    class="dashboard-head">

    <h1 class="app-h1-grey">
        Editor of information and article content
    </h1>

    <p class="app-paragraph-grey">
        Here the article's are entered into the system, listed and, when necessary, the data concerning them is
        modified.
    </p>
</div>

<div class="dashboard-grid">
    <div>
        <div class="flex items-center">
            <i class="bi bi-archive icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                Record
            </h2>
        </div>

        <p class="paragraph-grey">
            Inserts a new article into the system, allowing you to edit its content at the same time.
        </p>
        <p class="paragraph-grey">
            Please be careful, all fields are required.
            The first two range from a minimum of ten to a maximum of two hundred and fifty-five characters.
            The third field requires a minimum of ten characters.
            The last field requires a minimum of twenty characters.
            But the most important thing is that the title must be unique.
            Thanks for the attention.
        </p>

        <div class="paragraph-grey">
            <livewire:article.create-article />
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-list-ul icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                List
            </h2>
        </div>

        <div class="paragraph-grey">
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
