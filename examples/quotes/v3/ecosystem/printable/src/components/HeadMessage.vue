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
  <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2 lg:gap-8 lg:p-8">
    <div class="flex items-center">
      <h1 class="text-2xl text-slate-400">{{ message }}</h1>
    </div>
    <div class="flex items-center">
      <input v-model="filtered" @input="chose()"
        class="m-4 text-lg rounded-lg border border-slate-300 caret-indigo-700 focus:border-2 focus:border-indigo-500 text-slate-600"
        type="text" name="articleFilter" id="articleFilter" placeholder="Search..." />
    </div>
  </div>
</template>
