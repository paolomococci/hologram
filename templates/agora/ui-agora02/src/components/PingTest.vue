<script setup>
import PingEndpointTest from './PingEndpointTest.vue'

defineProps({
  title: String,
})
</script>

<template>
    <div class="items-center">
        <h3 class="my-4 text-2xl text-center text-purple-400">{{ title }}</h3>
        <PingEndpointTest />
    </div>
</template>
