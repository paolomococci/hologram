import { ref } from 'vue'
import { defineStore } from 'pinia'

export const commonCheckStore = defineStore('commonCheck', () => {
  const dataFileIsSelected = ref(false)
  const formaMentisIsSelected = ref(false)

  return { dataFileIsSelected, formaMentisIsSelected }
})

export const uploadMessageStore = defineStore('uploadMessages', () => {
  const resultMessage = ref(null)
  const rangeErrorMessage = ref([])
  const errorMessage = ref(null)

  return { resultMessage, rangeErrorMessage, errorMessage }
})

export const ponderMessageStore = defineStore('ponderMessages', () => {
  const inProcess = ref('display: none;')
  const resultMessage = ref(null)
  const errorMessage = ref(null)

  return { inProcess, resultMessage, errorMessage }
})

export const clipMessageStore = defineStore('clipMessages', () => {
  const resultMessage = ref(null)
  const errorMessage = ref(null)

  return { resultMessage, errorMessage }
})

export const estimateMessageStore = defineStore('estimateMessages', () => {
  const resultMessage = ref(null)
  const alertMessage = ref(null)
  const errorMessage = ref(null)

  return { resultMessage, alertMessage, errorMessage }
})

export const playgroundMessageStore = defineStore('playgroundMessages', () => {
  const resultMessage = ref(null)
  const errorMessage = ref(null)

  return { resultMessage, errorMessage }
})
