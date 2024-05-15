<script setup>
import { defineProps } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ExtensionLayout from '@/Pages/Tabs/Extensions/Layout/ExtensionLayout.vue'

const props = defineProps({
    value: Number
 })
</script>

<template>
    <AppLayout title="Extension">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Extension
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">

                    <!-- allows you to receive the event emitted by the child component -->
                    <ExtensionLayout :value="props?.value" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* TODO */
</style>
