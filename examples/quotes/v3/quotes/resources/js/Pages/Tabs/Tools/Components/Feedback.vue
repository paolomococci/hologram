<script setup>
import { defineProps } from "vue"

const props = defineProps({
    feedback: String,
})
</script>

<template>
    <!-- todo -->
    <div>
        <p v-if="props.feedback">{{ props.feedback }}</p>
    </div>
</template>
