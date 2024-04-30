<script setup>
import { defineProps, defineEmits } from 'vue'
import CloseIcon from '@/Icons/CloseIcon.vue'

const props = defineProps({
    feedback: String,
})

const emit = defineEmits(['resetFeedbackMessage'])

/** resets the content of the feedback by emitting it to the parent components */
function resetMessage() {
    emit('resetFeedbackMessage', undefined)
}
</script>

<template>
    <div v-if="props.feedback" class="p-2 m-2 bg-indigo-100 rounded-lg">
        <!-- allows the emission of an event to the parent components -->
        <button class="mr-8" v-on:click="resetMessage()">
            <CloseIcon class="size-8" />
        </button>

        <p class="text-lg text-center text-indigo-500">
            {{ props.feedback }}
        </p>
    </div>
</template>
