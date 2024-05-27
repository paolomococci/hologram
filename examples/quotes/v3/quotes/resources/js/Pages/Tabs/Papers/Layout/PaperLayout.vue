<script setup>
import { ref } from 'vue'
import PapersIcon from '@/Icons/PapersIcon.vue'
import UploadElementIcon from '@/Icons/UploadElementIcon.vue'
import FetchDataIcon from '@/Icons/FetchDataIcon.vue'
import EditElementIcon from '@/Icons/EditElementIcon.vue'
import FilterElementIcon from '@/Icons/FilterElementIcon.vue'
import PaperCreate from '@/Pages/Tabs/Papers/Components/Create.vue'
import PaperPaginated from '@/Pages/Tabs/Papers/Components/TablePaginated.vue'
import PaperEditor from '@/Pages/Tabs/Papers/Components/Edit.vue'
import PaperFiltered from '@/Pages/Tabs/Papers/Components/TableFiltered.vue'
import Feedback from '@/Pages/Tabs/Common/FeedbackCommon.vue'

const props = defineProps({
    feedback: String,
    papers: Object
})

const itemId = ref(0)
const editorOneIsVisible = ref(true)
const editorTwoIsVisible = ref(false)

/** to retrieve the item identifier from the child component that displays the essential data and notifies the child component that allows it to be updated */
function retransmitItemIdentifier(id) {
    itemId.value = id
    console.log(itemId.value)
    toggleEditor()
}

/** activates the form fields with the data to be modified each time a new identifier is passed */
function toggleEditor() {
    editorOneIsVisible.value = !editorOneIsVisible.value
    editorTwoIsVisible.value = !editorTwoIsVisible.value
}

/** processes feedback from the child */
function postMessage(message) {
    console.log(`PaperLayout component: ${message}`)
    props.feedback = message
}

/** clean feedback */
function cleanFeedback() {
    props.feedback = ''
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

            <Feedback @resetFeedbackMessage="() => cleanFeedback()" :feedback="props?.feedback" />
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

                <PaperCreate @postFeedbackMessage="(message) => postMessage(message)" />
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

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    To edit the x you need to click on the identification number at the beginning of the line.
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

                <div v-if="editorOneIsVisible">
                    <PaperEditor @postFeedbackMessage="(message) => postMessage(message)" :itemId="itemId" />
                </div>

                <div v-if="editorTwoIsVisible">
                    <PaperEditor @postFeedbackMessage="(message) => postMessage(message)" :itemId="itemId" />
                </div>
            </div>

            <div>
                <div class="flex items-center">
                    <FilterElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Filter</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Filter scanned papers by title and content.
                </p>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    To edit the x you need to click on the identification number at the beginning of the line.
                </p>

                <PaperFiltered @grabItemIdentifierFromTable="(id) => retransmitItemIdentifier(id)" />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* TODO */
</style>
