<div
    class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">

    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        OCR (Optical Character Recognition)
    </h1>

    <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
        In this tab it is possible to upload previously scanned documents to be subjected to Optical Character Recognition.
    </p>
</div>

<div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
    <div>
        <div class="flex items-center">
            <i class="bi bi-upload icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                Upload
            </h2>
        </div>

        <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            To load a file that takes up a maximum of 2 megabytes of memory you need to click on the label indicated below and choose a file from your device.
        </p>

        <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            Attention, to save data in the database you need to provide a title. Otherwise only the indicated file will be loaded.
        </p>

        <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            <livewire:paper.upload-paper />
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
            Below is a list of files loaded on the system.
        </div>

        <div class="mt-4 text-sm">
            <livewire:paper.overview-papers />
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-clipboard icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                Clipboard
            </h2>
        </div>

        <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            Here the textual content contained in the document just examined is highlighted.
        </div>

        <div class="mt-4 text-sm">
            <livewire:paper.overview-papers />
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <i class="bi bi-trash icon-2-logged"></i>
            <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                Trash
            </h2>
        </div>

        <div class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
            Section dedicated to emptying the directory which contains a copy of the documents examined.
        </div>

        <div class="mt-4 text-sm">
            <livewire:paper.overview-papers />
        </div>
    </div>
</div>
