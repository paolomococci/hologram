<script setup>
import { ref } from 'vue'

defineProps({
  msg: String,
})

const count = ref(0)
</script>

<template>
  <h3 class="text-indigo-400">{{ msg }}</h3>

  <div class="card">
    <button class="text-indigo-400" type="button" @click="count++">count is {{ count }}</button>
  </div>

</template>
