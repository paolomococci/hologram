<script setup>
import { ref } from 'vue'

defineProps({
  msg: String,
})

const count = ref(0)
</script>

<template>
  <h3>{{ msg }}</h3>

  <div class="card">
    <button type="button" @click="count++">count is {{ count }}</button>
  </div>

</template>
