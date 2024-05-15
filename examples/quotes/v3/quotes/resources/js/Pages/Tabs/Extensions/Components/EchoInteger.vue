<template>
    <p v-if="props?.value" class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
        Last value echoed:
    </p>

    <Feedback @resetFeedbackMessage="() => cleanFeedback()" :feedback="props?.value" />
</template>

<script setup>
import { defineProps } from 'vue'
import Feedback from '@/Pages/Tabs/Common/FeedbackCommon.vue'
import { BASE } from '@/env.js'

const extensions = BASE + "extensions"

const props = defineProps({
    value: Number,
})

/** clean feedback */
function cleanFeedback() {
    props.feedback = ''
    window.location.href = extensions
}
</script>
