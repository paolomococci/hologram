<template>
    <div>
        <p>add a new author</p>
    </div>
</template>

<script setup>
import { reactive, defineProps } from "vue"
import { router } from "@inertiajs/vue3"

const props = defineProps({
    errors: Object
})

const createForm = reactive({
    name: null,
    surname: null,
    nickname: null,
    email: null,
})
    // TODO
</script>

<style scoped>
    /* TODO */
</style>
