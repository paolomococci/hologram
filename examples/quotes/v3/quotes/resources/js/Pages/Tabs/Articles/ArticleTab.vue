<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ArticleLayout from '@/Pages/Tabs/Articles/Layout/ArticleLayout.vue';
</script>

<template>
    <AppLayout title="Article">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Article
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                    <ArticleLayout />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* TODO */
</style>
