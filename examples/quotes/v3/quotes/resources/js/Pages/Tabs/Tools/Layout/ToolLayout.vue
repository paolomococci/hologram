<script setup>
import { defineProps, defineEmits } from 'vue'
import ToolsIcon from '@/Icons/ToolsIcon.vue'
import RenumberIcon from '@/Icons/RenumberIcon.vue'
import DottedListIcon from '@/Icons/DottedListIcon.vue'
import RightArrowIcon from '@/Icons/RightArrowIcon.vue'
import DropDataIcon from '@/Icons/DropDataIcon.vue'
import { BASE } from '@/env.js'
import Feedback from '@/Pages/Tabs/Common/FeedbackCommon.vue'

const props = defineProps({
    feedback: String,
})

const emit = defineEmits(['resetFeedbackMessage'])

const renumberUri = BASE + "renumber"
const cleanUri = BASE + "clean"
const renumberPapersUri = BASE + "renumber-papers"

/** collects what the child component emitted and transmits it back to the parent component */
function resetMessage(message) {
    console.log(`ToolLayout: ${message}`)
    props.feedback = message
    emit('resetFeedbackMessage', message)
}
</script>

<template>
    <div>
        <div
            class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
            <ToolsIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Tools for routine technical maintenance.
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                Here are some useful tools to maintain data consistency.
            </p>

            <!-- allows the emission of an event to the parent component, retransmitting what it received from the child component -->
            <Feedback @resetFeedbackMessage="(message) => resetMessage(message)" :feedback="feedback" />
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">
                    <RenumberIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Renumber correlations</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Tool that regenerates the numerical identifiers of the table that maintains the correlations between
                    the author and the article he contributed to writing.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="renumberUri"
                        class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        renumber the correlation table

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <DropDataIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Clean all tables</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Tool that cleans the database of all data and restarts the numbering of the respective IDs from one.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="cleanUri"
                        class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        deletes all data from the database

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">
                    <DottedListIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Renumber papers</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    It also sequentially regenerates the papers table's numeric identifiers.
                </p>

                <p class="mt-4 text-sm">
                    <a :href="renumberPapersUri"
                        class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        renumber the papers table

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>

            <div
                class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
                <div class="flex items-center">
                    <!-- TODO: add icon -->
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>
                            <!-- TODO: add a descriptive title -->
                        </span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    <!-- TODO: add a brief explanation of what the tool does -->
                </p>

                <p class="mt-4 text-sm">
                    <a href="#"
                        class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        <!-- TODO: add a descriptive text of link -->

                        <!-- <RightArrowIcon class="size-4" /> -->
                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* TODO */
</style>
