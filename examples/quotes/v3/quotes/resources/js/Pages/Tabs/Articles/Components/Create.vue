<template>
    <div>
        <p>add a new article</p>
    </div>
</template>

<script setup>
import { reactive, defineProps } from "vue"
import { router } from "@inertiajs/vue3"

const props = defineProps({
    errors: Object
})

const createForm = reactive({
    title: null,
    subject: null,
    summary: null,
    content: null,
})
    // TODO
</script>

<style scoped>
    /* TODO */
</style>
