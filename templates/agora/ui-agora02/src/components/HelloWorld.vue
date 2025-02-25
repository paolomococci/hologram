<script setup>
import { ref } from 'vue'
import { Plus } from 'lucide-vue-next'

defineProps({
  msg: String,
})

const count = ref(0)
</script>

<template>
  <h3 class="text-indigo-400">{{ msg }}</h3>

  <div class="card">
    <button id="increment" class="text-indigo-400" type="button" @click="count++"><Plus :size="32" /></button>
    <output for="increment" class="block mt-4 text-2xl text-indigo-400">{{ count }}</output>
  </div>

</template>
