<script setup>
import { ref } from "vue"
import PapersIcon from '@/Icons/PapersIcon.vue'
import UploadElementIcon from '@/Icons/UploadElementIcon.vue'
import FetchDataIcon from '@/Icons/FetchDataIcon.vue'
import EditElementIcon from '@/Icons/EditElementIcon.vue'
import FilterElementIcon from '@/Icons/FilterElementIcon.vue'
import PaperCreate from '@/Pages/Tabs/Papers/Components/Create.vue'
import PaperPaginated from '@/Pages/Tabs/Papers/Components/TablePaginated.vue'
import PaperEditor from '@/Pages/Tabs/Papers/Components/Edit.vue'
import PaperFiltered from '@/Pages/Tabs/Papers/Components/TableFiltered.vue'

const props = defineProps({
    feedback: String,
    papers: Object
})

const itemId = ref(0)

/** to retrieve the item identifier from the child component that displays the essential data and notifies the child component that allows it to be updated */
function retransmitItemIdentifier(id) {
    itemId.value = id
    console.log(itemId.value)
    // toggleEditor()
}
</script>

<template>
    <div>
        <div
            class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
            <PapersIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                OCR (Optical Character Recognition)
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                In this tab it is possible to upload previously scanned documents to be subjected to Optical Character
                Recognition.
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

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    To load a file that takes up a maximum of 2 megabytes of memory you need to click on the label
                    indicated below and choose a file from your device.
                </p>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Attention, to save data in the database you need to provide a title. Otherwise only the indicated
                    file will be loaded.
                </p>

                <PaperCreate />
            </div>

            <div>
                <div class="flex items-center">
                    <FetchDataIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Index</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Below is the list of titles of the image files scanned and listed starting from the last one
                    registered in the system.
                </p>

                <PaperPaginated caption="fetched paper data from RDBMS" :papers="props.papers"
                    @grabItemIdentifierFromTable="(id) => retransmitItemIdentifier(id)" />
            </div>

            <div>
                <div class="flex items-center">
                    <EditElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Clipboard</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Here the textual content contained in the document just examined is highlighted.
                </p>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Here it can be reviewed and corrected and then copied and finally used in recording the articles in
                    the system.
                </p>

                <PaperEditor />
            </div>

            <div>
                <div class="flex items-center">
                    <FilterElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Filter and Delete</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Section dedicated to emptying the directory which contains a copy of the documents examined and to
                    delete all the elements recorded in the table dedicated to them.
                </p>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Since this tab is intended only as a tool to speed up the insertion of articles into the system.
                </p>

                <PaperFiltered />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* TODO */
</style>
