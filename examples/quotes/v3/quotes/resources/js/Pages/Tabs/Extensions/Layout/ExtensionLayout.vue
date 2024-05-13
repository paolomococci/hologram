<script setup>
import { defineProps, defineEmits } from 'vue'
import WithCautionIcon from '@/Icons/WithCautionIcon.vue'
import DutyAttentionIcon from '@/Icons/DutyAttentionIcon.vue'
import RightArrowIcon from '@/Icons/RightArrowIcon.vue'
import Feedback from '@/Pages/Tabs/Common/FeedbackCommon.vue'
import { BASE } from '@/env.js'

const props = defineProps({
    feedback: String,
})

const emit = defineEmits(['resetFeedbackMessage'])

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
            <WithCautionIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Extensions for testing FFI capabilities.
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                Here are some useful extensions.
            </p>

            <!-- allows the emission of an event to the parent component, retransmitting what it received from the child component -->
            <Feedback @resetFeedbackMessage="(message) => resetMessage(message)" :feedback="feedback" />
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">
                    <DutyAttentionIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>TODO</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    TODO.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#"
                        class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        todo

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">
                    <DutyAttentionIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>TODO</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    TODO.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#"
                        class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                        todo

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
