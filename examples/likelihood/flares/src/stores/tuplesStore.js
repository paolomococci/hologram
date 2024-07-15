import { ref } from 'vue'
import { defineStore } from 'pinia'

export const tuplesDataStore = defineStore('tuplesData', () => {
  const trainingDataField = ref(null)
  const tuples = ref(null)
  const name = ref(null)

  return { trainingDataField, tuples, name }
})
