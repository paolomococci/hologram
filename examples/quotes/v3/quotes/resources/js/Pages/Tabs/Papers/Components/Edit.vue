<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.id" size="30" type="text" name="id" id="id" placeholder="#" readonly />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.title" size="30" type="text" name="title" id="title" placeholder="Title"
                    readonly />
            </div>
            <div>
                <textarea
                    class="left-4 m-2 max-h-60 text-xs rounded-md border border-purple-300 min-h-36 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.content" name="content" id="content" cols="30" rows="10"
                    placeholder="Content" required minlength="32" maxlength="1024"></textarea>
            </div>
            <div>
                <progress class="mb-4 w-full h-1 bg-purple-400 rounded-lg dark:bg-purple-600" v-if="editForm.progress"
                    :value="editForm.progress.percentage" max="100">
                    {{ editForm.progress.percentage }}%
                </progress>
            </div>
            <div>
                <button
                    class="px-2 py-1 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm"
                    type="submit" :disabled="editForm.processing" @click="postMessage()">Save</button>
                <button
                    class="px-2 py-1 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm"
                    type="reset">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onBeforeMount } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import axios from 'axios'

const props = defineProps({
    itemId: String
})

const emit = defineEmits(['postFeedbackMessage'])

onBeforeMount(() => {
    fetchDataItem(props?.itemId)
})

/** transmits it back to the parent component */
function postMessage() {
    if (fieldEmptyCheck()) {
        console.log('You have just updated an paper with the following title: ' + editForm.title)
        emit('postFeedbackMessage', `You have just updated an paper with the following title: ${editForm.title}`)
    } else {
        console.log('Attention, the form has not been filled out correctly!')
        emit('postFeedbackMessage', 'Attention, the form has not been filled out correctly!')
    }
}

const editForm = useForm({
    id: null,
    title: null,
    content: null
})

/** sends the values and clears the fields */
function submit() {
    if (fieldEmptyCheck()) {
        router.put("/papers", editForm)
        editForm.id = '#'
        editForm.title = ''
        editForm.content = ''
    } else {
        console.log(editForm)
        alert("Attention please: the title and content fields are mandatory!")
        fetchDataItem(editForm.id)
    }
}

/** fetch data of item thanks to the id */
async function fetchDataItem(id) {
    if (id > 0) {
        try {
            const res = await axios.get("/papers/show/" + id)
            if (res.status) {
                console.log(res.data)
                editForm.id = res.data.id
                editForm.title = res.data.title
                editForm.content = res.data.content
            }
            console.log(res)
        } catch (error) {
            console.log(error)
        }
    }
}

/** check if the mandatory fields have been filled in */
function fieldEmptyCheck() {
    let checkField = editForm.title != '' && editForm.content != '' && editForm.title != null && editForm.content != null
    return checkField
}

/** dynamically assigns an identifier to the affected tags */
function setId(id) {
    return `disrelate_${id}`
}
</script>

<style scoped>
/* TODO */
</style>
