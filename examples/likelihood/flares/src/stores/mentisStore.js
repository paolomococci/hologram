import { ref } from 'vue'
import { defineStore } from 'pinia'

export const formaMentisStore = defineStore('formaMentis', () => {
  const mentis = ref(null)

  return { mentis }
})

export const blobJsonNeuralNetStore = defineStore('blobJsonNeuralNet', () => {
  const name = ref(null)
  const blob = ref(null)

  return { name, blob }
})
