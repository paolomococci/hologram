<script setup>
import { ref } from "vue"
import AuthorsIcon from '@/Icons/AuthorsIcon.vue'
import AddElementIcon from '@/Icons/AddElementIcon.vue'
import FetchDataIcon from '@/Icons/FetchDataIcon.vue'
import EditElementIcon from '@/Icons/EditElementIcon.vue'
import FilterElementIcon from '@/Icons/FilterElementIcon.vue'
import AuthorCreate from '@/Pages/Tabs/Authors/Components/Create.vue'
import AuthorPaginated from '@/Pages/Tabs/Authors/Components/TablePaginated.vue'
import AuthorEditor from '@/Pages/Tabs/Authors/Components/Edit.vue'
import AuthorFiltered from '@/Pages/Tabs/Authors/Components/TableFiltered.vue'
import Feedback from '@/Pages/Tabs/Common/FeedbackCommon.vue'

const props = defineProps({
    feedback: String,
    authors: Object
})

const itemId = ref(0)
const editorOneIsVisible = ref(true)
const editorTwoIsVisible = ref(false)

/** to retrieve the item identifier from the child component that displays the essential data and notifies the child component that allows it to be updated */
function retransmitItemIdentifier(id) {
    itemId.value = id
    // console.log(itemId.value)
    toggleEditor()
}

function toggleEditor() {
    editorOneIsVisible.value = !editorOneIsVisible.value
    editorTwoIsVisible.value = !editorTwoIsVisible.value
}

/** processes feedback from the child */
function postMessage(message) {
    console.log(`AuthorLayout component: ${message}`)
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
            <AuthorsIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                To record, view, filter and edit author data
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                Here the author's are entered into the system, listed and, when necessary, the data concerning them is
                modified.
            </p>

            <Feedback @resetFeedbackMessage="() => cleanFeedback()" :feedback="props?.feedback" />
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">
                    <AddElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Add</span>
                    </h2>
                </div>

                <AuthorCreate @postFeedbackMessage="(message) => postMessage(message)" />
            </div>

            <div>
                <div class="flex items-center">
                    <FetchDataIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Index</span>
                    </h2>
                </div>

                <AuthorPaginated caption="fetched author data from RDBMS" :authors="props.authors"
                    @grabItemIdentifierFromTable="(id) => retransmitItemIdentifier(id)" />
            </div>

            <div>
                <div class="flex items-center">
                    <EditElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Edit</span>
                    </h2>
                </div>

                <div v-if="editorOneIsVisible">
                    <AuthorEditor @postFeedbackMessage="(message) => postMessage(message)" :itemId="itemId" />
                </div>

                <div v-if="editorTwoIsVisible">
                    <AuthorEditor @postFeedbackMessage="(message) => postMessage(message)" :itemId="itemId" />
                </div>
            </div>

            <div>
                <div class="flex items-center">
                    <FilterElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Filtering</span>
                    </h2>
                </div>

                <AuthorFiltered @grabItemIdentifierFromTable="(id) => retransmitItemIdentifier(id)" />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* TODO */
</style>
