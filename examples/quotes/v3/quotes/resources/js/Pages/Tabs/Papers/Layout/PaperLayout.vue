<script setup>
import PapersIcon from '@/Icons/PapersIcon.vue'
import UploadElementIcon from '@/Icons/UploadElementIcon.vue'
import FetchDataIcon from '@/Icons/FetchDataIcon.vue'
import EditElementIcon from '@/Icons/EditElementIcon.vue'
import FilterElementIcon from '@/Icons/FilterElementIcon.vue'
import PaperUpload from '@/Pages/Tabs/Papers/Components/Upload.vue'
import PaperPaginated from '@/Pages/Tabs/Papers/Components/TablePaginated.vue'
import PaperEditor from '@/Pages/Tabs/Papers/Components/Edit.vue'
import PaperFiltered from '@/Pages/Tabs/Papers/Components/TableFiltered.vue'
</script>

<template>
    <div>
        <div
            class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
            <PapersIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                To record, view, filter and edit paper data
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                This is the tab where you process scanned documents.
            </p>
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">
                    <UploadElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Upload</span>
                    </h2>
                </div>

                <PaperUpload />
            </div>

            <div>
                <div class="flex items-center">
                    <FetchDataIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Index</span>
                    </h2>
                </div>

                <PaperPaginated />
            </div>

            <div>
                <div class="flex items-center">
                    <EditElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Edit</span>
                    </h2>
                </div>

                <PaperEditor />
            </div>

            <div>
                <div class="flex items-center">
                    <FilterElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Filtering</span>
                    </h2>
                </div>

                <PaperFiltered />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* TODO */
</style>
