<script setup>
import PapersIcon from '@/Icons/PapersIcon.vue';
import AddElementIcon from '@/Icons/AddElementIcon.vue';
import RightArrowIcon from '@/Icons/RightArrowIcon.vue';
import FetchDataIcon from '@/Icons/FetchDataIcon.vue';
import EditElementIcon from '@/Icons/EditElementIcon.vue';
import FilterElementIcon from '@/Icons/FilterElementIcon.vue';
</script>

<template>
    <div>
        <div
            class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
            <PapersIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Welcome to the papers tab!
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                A simple description that introduces the user to the use of this application.
            </p>
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">
                    <AddElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <a href="#">Add</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Create.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        Explore the documentation

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <FetchDataIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <a href="#">Index</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Read all element to pagination.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        Pagination

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <EditElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <a href="#">Edit</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Edit papers content.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        Update contents

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <FilterElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        Filtering
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Filter papers by content.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        Filter by content

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
