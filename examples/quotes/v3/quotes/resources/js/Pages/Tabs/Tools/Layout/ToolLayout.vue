<script setup>
import { defineProps } from "vue"
import ToolsIcon from '@/Icons/ToolsIcon.vue';
import RenumberIcon from '@/Icons/RenumberIcon.vue';
import RightArrowIcon from '@/Icons/RightArrowIcon.vue';
import DropDataIcon from '@/Icons/DropDataIcon.vue';
import { BASE } from "@/env.js"

const props = defineProps({
    feedback: String,
})

const renumberUri = BASE + "renumber"
const cleanUri = BASE + "clean"
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

            <p v-if="props.feedback">{{ props.feedback }}</p>
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">
                    <RenumberIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <a href="#">Renumber</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Tool that regenerates the numerical identifiers of the table that maintains the correlations between
                    the
                    author and the article he contributed to writing.
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
                        <a href="#">Clean</a>
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
    </div>
</template>

<style scoped>
/* TODO */
</style>
