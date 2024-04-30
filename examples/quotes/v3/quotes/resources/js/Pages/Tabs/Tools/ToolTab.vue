<script setup>
import { defineProps } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ToolLayout from '@/Pages/Tabs/Tools/Layout/ToolLayout.vue'
import { BASE } from '@/env.js'

const tools = BASE + "tools"

const props = defineProps({ feedback: String })

/** processes what it receives from the child component by cleaning up the content of the feedback and returns to the tools tab */
function resetMessage(message) {
    console.log(`ToolTab: ${message}`)
    props.feedback = message
    window.location.href = tools
}
</script>

<template>
    <AppLayout title="Tool">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Tool
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">

                    <!-- allows you to receive the event emitted by the child component -->
                    <ToolLayout @resetFeedbackMessage="(message) => resetMessage(message)" :feedback="feedback" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* TODO */
</style>
