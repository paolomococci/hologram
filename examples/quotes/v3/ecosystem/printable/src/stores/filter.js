import { defineStore } from 'pinia'
import { ref } from 'vue'

export const filterStore = defineStore(
    'filter',
    () => {
        const filterText = ref('')
        return { filterText }
    }
)