<script setup>
import ArticlesIcon from '@/Icons/ArticlesIcon.vue'
import AddElementIcon from '@/Icons/AddElementIcon.vue'
import FetchDataIcon from '@/Icons/FetchDataIcon.vue'
import EditElementIcon from '@/Icons/EditElementIcon.vue'
import FilterElementIcon from '@/Icons/FilterElementIcon.vue'
import ArticleCreate from '@/Pages/Tabs/Articles/Components/Create.vue'
import ArticlePaginated from '@/Pages/Tabs/Articles/Components/TablePaginated.vue'
import ArticleEditor from '@/Pages/Tabs/Articles/Components/Edit.vue'
import ArticleFiltered from '@/Pages/Tabs/Articles/Components/TableFiltered.vue'
</script>

<template>
    <div>
        <div
            class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
            <ArticlesIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Welcome to the articles tab!
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

                <ArticleCreate />
            </div>

            <div>
                <div class="flex items-center">
                    <FetchDataIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Index</span>
                    </h2>
                </div>

                <ArticlePaginated />
            </div>

            <div>
                <div class="flex items-center">
                    <EditElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Edit</span>
                    </h2>
                </div>

                <ArticleEditor />
            </div>

            <div>
                <div class="flex items-center">
                    <FilterElementIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Filtering</span>
                    </h2>
                </div>

                <ArticleFiltered />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* TODO */
</style>
