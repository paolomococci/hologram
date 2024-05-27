import { reactive } from 'vue'

export const authorStore = reactive({
    name: '',
    surname: '',
    nickname: '',
    email: '',
})

export const articleStore = reactive({
    title: '',
    subject: '',
    summary: '',
    content: '',
})

export const paperStore = reactive({
    title: '',
})
