<div
    class="dashboard-head">

    <h1 class="app-h1-grey">
        OCR (Optical Character Recognition)
    </h1>

    <p class="app-paragraph-grey">
        In this tab it is possible to upload previously scanned documents to be subjected to Optical Character Recognition.
    </p>
</div>

<div class="dashboard-grid">
    <div>
        <div class="flex items-center">
            <i class="bi bi-upload icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                Upload
            </h2>
        </div>

        <p class="paragraph-grey">
            To load a file that takes up a maximum of 2 megabytes of memory you need to click on the label indicated below and choose a file from your device.
        </p>

        <p class="paragraph-grey">
            Attention, to save data in the database you need to provide a title. Otherwise only the indicated file will be loaded.
        </p>

        <div class="paragraph-grey">
            <livewire:paper.upload-paper />
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
            Below is the list of file titles uploaded to the system, accompanied by the timestamp.
        </div>

        <div class="mt-4 text-sm">
            <livewire:paper.overview-papers />
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-clipboard icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                Clipboard
            </h2>
        </div>

        <div class="paragraph-grey">
            Here the textual content contained in the document just examined is highlighted.
        </div>

        <div class="mt-4 text-sm">
            {{-- <livewire:paper.overview-papers /> --}}
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-trash icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                Trash
            </h2>
        </div>

        <div class="paragraph-grey">
            Section dedicated to emptying the directory which contains a copy of the documents examined.
        </div>

        <div class="mt-4 text-sm">
            {{-- <livewire:paper.overview-papers /> --}}
        </div>
    </div>
</div>
