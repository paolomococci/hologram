<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import AuthorLayout from '@/Pages/Tabs/Authors/Layout/AuthorLayout.vue'

const props = defineProps({
    feedback: String,
    authors: Object
})
</script>

<template>
    <AppLayout title="Author">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Author
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                    <AuthorLayout :authors="props?.authors" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* TODO */
</style>
