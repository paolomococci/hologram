<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PaperLayout from '@/Pages/Tabs/Papers/Layout/PaperLayout.vue';
</script>

<template>
    <AppLayout title="Paper">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Paper
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                    <PaperLayout />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* TODO */
</style>
