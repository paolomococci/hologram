<script setup>
import AuthorsIcon from '@/Icons/AuthorsIcon.vue'
import AddElementIcon from '@/Icons/AddElementIcon.vue'
import FetchDataIcon from '@/Icons/FetchDataIcon.vue'
import EditElementIcon from '@/Icons/EditElementIcon.vue'
import FilterElementIcon from '@/Icons/FilterElementIcon.vue'
import AuthorCreate from '@/Pages/Tabs/Authors/Components/Create.vue'
import AuthorPaginated from '@/Pages/Tabs/Authors/Components/TablePaginated.vue'
import AuthorEditor from '@/Pages/Tabs/Authors/Components/Edit.vue'
import AuthorFiltered from '@/Pages/Tabs/Authors/Components/TableFiltered.vue'
</script>

<template>
    <div>
        <div
            class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
            <AuthorsIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Welcome to the authors tab!
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                A simple description that introduces the user to the use of this tab.
            </p>
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

                <AuthorCreate />
            </div>

            <div>
                <div class="flex items-center">
                    <FetchDataIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Index</span>
                    </h2>
                </div>

                <AuthorPaginated />
            </div>

            <div>
                <div class="flex items-center">
                    <EditElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Edit</span>
                    </h2>
                </div>

                <AuthorEditor />
            </div>

            <div>
                <div class="flex items-center">
                    <FilterElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Filtering</span>
                    </h2>
                </div>

                <AuthorFiltered />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* TODO */
</style>
