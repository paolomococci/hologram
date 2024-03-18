<div
    class="dashboard-head">

    <h1 class="app-h1-grey">
        Editor of author information
    </h1>

    <p class="app-paragraph-grey">
        Here are some useful tools to maintain data consistency.
    </p>
</div>

<div class="dashboard-grid">
    <div>
        <div class="flex items-center">
            <i class="bi bi-list-ol icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                <a href="#">Renumber</a>
            </h2>
        </div>

        <p class="paragraph-grey">
            Tool that regenerates the numerical identifiers of the table that maintains the correlations between the
            author and the article he contributed to writing.
        </p>

        <p class="mt-4 text-sm">
            <livewire:contributor.renumber-contrib />
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-recycle icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                <a href="#">Clean the database</a>
            </h2>
        </div>

        <p class="paragraph-grey">
            Tool that cleans the database of all data and restarts the numbering of the respective IDs from one.
        </p>

        <p class="mt-4 text-sm">
            <livewire:contributor.clear-data />
        </p>
    </div>
</div>
