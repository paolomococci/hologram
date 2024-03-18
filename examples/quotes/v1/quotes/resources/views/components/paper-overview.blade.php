<div class="dashboard-head">

    <h1 class="app-h1-grey">
        OCR (Optical Character Recognition)
    </h1>

    <p class="app-paragraph-grey">
        In this tab it is possible to upload previously scanned documents to be subjected to Optical Character
        Recognition.
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
            To load a file that takes up a maximum of 2 megabytes of memory you need to click on the label indicated
            below and choose a file from your device.
        </p>

        <p class="paragraph-grey">
            Attention, to save data in the database you need to provide a title. Otherwise only the indicated file will
            be loaded.
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

        <p class="paragraph-grey">
            Below is the list of file titles uploaded to the system, accompanied by the timestamp.
        </p>

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

        <p class="paragraph-grey">
            Here the textual content contained in the document just examined is highlighted.
        </p>
        <p class="paragraph-grey">
            Here it can be reviewed and corrected and then copied and finally used in recording the articles in the
            system.
        </p>

        <div class="mt-4 text-sm">
            <livewire:paper.update-paper />
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-trash icon-2-logged"></i>
            <h2 class="app-anchor-grey">
                Trash
            </h2>
        </div>

        <p class="paragraph-grey">
            Section dedicated to emptying the directory which contains a copy of the documents examined and to delete
            all the elements recorded in the table dedicated to them.
        </p>
        <p class="paragraph-grey">
            Since this tab is intended only as a tool to speed up the insertion of articles into the system.
        </p>

        <div class="mt-4 text-sm">
            <livewire:paper.delete-all-papers />
        </div>
    </div>
</div>
