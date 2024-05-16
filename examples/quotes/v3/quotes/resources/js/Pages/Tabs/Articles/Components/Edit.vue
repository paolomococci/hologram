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
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.subject" size="30" type="text" name="subject" id="subject"
                    placeholder="Subject" required minlength="16" maxlength="255" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.summary" size="30" type="text" name="summary" id="summary"
                    placeholder="Summary" maxlength="255" />
            </div>
            <div>
                <textarea
                    class="left-4 m-2 max-h-60 text-xs rounded-md border border-purple-300 min-h-36 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.content" name="content" id="content" cols="30" rows="10"
                    placeholder="Content" required minlength="32" maxlength="1024"></textarea>
            </div>
            <div class="pb-4">
                <label class="left-4 text-gray-900 text-md-center ms-3 dark:text-white"
                    for="deprecated">deprecated</label>
                <input class="left-4 ml-2 text-xs rounded-md border indeterminate:bg-gray-300 checked:bg-purple-700"
                    type="checkbox" v-model.lazy="editForm.deprecated" name="deprecated" id="deprecated">
            </div>
            <div v-if="hasContributors()" class="pb-4">
                <p class="left-4 text-xs text-gray-900 ms-3 dark:text-white">
                    Has received contributions from the following authors:
                </p>
                <div class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                    <ul>
                        <li class="left-4 text-xs text-gray-900 ms-3 dark:text-slate-200"
                            v-for="contributor in editForm?.contributors" :key="contributor.id">
                            {{ contributor.email }}
                        </li>
                    </ul>
                </div>
            </div>
            <div v-if="editForm?.id" class="pb-4">
                <p class="left-4 text-xs text-gray-900 ms-3 dark:text-white" for="author">
                    Add a correlation to the following author:
                </p>
                <select id="authors" v-model.lazy="editForm.correlation" class="left-4 ml-2 text-xs rounded-md border">
                    <option class="text-xs rounded-md border indeterminate:bg-gray-300 checked:bg-purple-700" value="0">
                        none
                    </option>
                    <option
                        class="text-xs rounded-md border indeterminate:bg-gray-300 checked:bg-purple-700 hover:bg-purple-400"
                        v-for="author in editForm?.authors" :key="author.id" :value="author.id">{{ author.email }}
                    </option>
                </select>
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
import { reactive, onBeforeMount } from 'vue'
import { router } from "@inertiajs/vue3"
import axios from "axios"

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
        console.log('You have just updated an article with the following title: ' + editForm.title)
        emit('postFeedbackMessage', `You have just updated an article with the following title: ${editForm.title}`)
    } else {
        console.log('Attention, the form has not been filled out correctly!')
        emit('postFeedbackMessage', 'Attention, the form has not been filled out correctly!')
    }
}

const editForm = reactive({
    id: null,
    title: null,
    subject: null,
    summary: null,
    content: null,
    deprecated: false,
    correlation: null,
    contributors: [],
    authors: [],
})

/** sends the values and clears the fields */
function submit() {
    if (fieldEmptyCheck()) {
        console.log(`Correlation: ${editForm.correlation}`)
        router.put("/articles", editForm)
        editForm.id = '#'
        editForm.title = ''
        editForm.subject = ''
        editForm.summary = ''
        editForm.content = ''
        editForm.deprecated = false
        editForm.correlation = null
    } else {
        console.log(editForm)
        alert("Attention please: the title, subject and content fields are mandatory!")
        fetchDataItem(editForm.id)
    }
}

/** fetch data of item thanks to the id */
async function fetchDataItem(id) {
    if (id > 0) {
        try {
            const res = await axios.get("/articles/show/" + id)
            if (res.status) {
                console.log(res.data)
                editForm.id = res.data.id
                editForm.title = res.data.title
                editForm.subject = res.data.subject
                editForm.summary = res.data?.summary
                editForm.content = res.data.content
                editForm.deprecated = res.data.deprecated ? true : false
                editForm.contributors = res.data?.contributors
                editForm.authors = res.data?.authors
            }
            console.log(res)
        } catch (error) {
            console.log(error)
        }
    }
}

/** check if the mandatory fields have been filled in */
function fieldEmptyCheck() {
    let checkField = (editForm.title != '' && editForm.subject != '' && editForm.content != '') &&
        (editForm.title != null && editForm.subject != null && editForm.content != null)
    return checkField
}

/** checks whether an article has been attributed to contributors */
function hasContributors() {
    if (editForm?.contributors.length > 0) {
        return true
    }
    return false;
}
</script>

<style scoped>
/* TODO */
</style>
