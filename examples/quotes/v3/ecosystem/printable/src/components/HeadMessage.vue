<script setup>
import { ref } from 'vue'
import { filterStore } from '@/stores/filter'

const filter = filterStore()
const filtered = ref(filter.filterText)

defineProps({
  message: {
    type: String,
    required: true
  }
})

function chose() {
  filter.filterText = filtered.value
}
</script>

<template>
  <div class="relative w-80 h-8 card">
    <h1 class="text-2xl text-slate-400 indent-8">{{ message }}</h1>
    <div class="">
      <div class="absolute inset-y-0 top-0 right-0 w-4">
        <input v-model="filtered" @input="chose()"
          class="absolute top-0 left-4 m-4 text-lg rounded-lg border border-slate-300 caret-indigo-700 focus:border-2 focus:border-indigo-500 text-slate-600"
          type="text" name="articleFilter" id="articleFilter" placeholder="Search..." />
      </div>
    </div>
  </div>
</template>

<style scoped></style>
