<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.title" size="30" type="text" name="title" id="title" placeholder="Title"
                    required minlength="16" maxlength="255" @blur="setStoredTitle()" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.subject" size="30" type="text" name="subject" id="subject"
                    placeholder="Subject" required minlength="16" maxlength="255" @blur="setStoredSubject()" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.summary" size="30" type="text" name="summary" id="summary"
                    placeholder="Summary" maxlength="255" @blur="setStoredSummary()" />
            </div>
            <div>
                <textarea
                    class="left-4 m-2 max-h-60 text-xs rounded-md border border-purple-300 min-h-36 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.content" name="content" id="content" cols="30" rows="10"
                    placeholder="Content" required minlength="32" maxlength="1024"
                    @blur="setStoredContent()"></textarea>
            </div>
            <div class="pb-4">
                <label class="left-4 text-xs text-gray-900 ms-3 dark:text-white" for="giverId">
                    Double click to choose the main author:
                </label>
                <input class="left-4 ml-2 text-xs rounded-md border indeterminate:bg-gray-300 checked:bg-purple-700"
                    v-model.lazy="createForm.giver" size="30" type="text" name="giverId" id="giverId"
                    list="contributors"
                    @blur="setStoredGiver()">
                <datalist id="contributors" class="left-4 ml-2 text-xs rounded-md border">
                    <option
                        class="text-xs rounded-md border indeterminate:bg-gray-300 checked:bg-purple-700 hover:bg-purple-400"
                        v-for="contributor in createForm?.contributors" :key="contributor.id" :value="contributor.email"
                        v-text="contributor.email"></option>
                </datalist>
            </div>
            <div>
                <progress class="mb-4 w-full h-1 bg-purple-400 rounded-lg dark:bg-purple-600" v-if="createForm.progress"
                    :value="createForm.progress.percentage" max="100">
                    {{ createForm.progress.percentage }}%
                </progress>
            </div>
            <div>
                <button
                    class="p-1 px-2 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm"
                    type="submit" :disabled="createForm.processing">Save</button>
                <button
                    class="p-1 px-2 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm"
                    type="reset" @click="clearStoredData()">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { defineEmits, onBeforeMount } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import { articleStore } from '@/store'

const emit = defineEmits(['postFeedbackMessage'])

onBeforeMount(() => {
    fetchContributors()
})

/** transmits it back to the parent component */
function postMessage() {
    if (fieldEmptyCheck()) {
        console.log('You have just registered a new article with the following basic title: ' + createForm.title)
        emit('postFeedbackMessage', `You have just registered a new article with the following basic title: ${createForm.title}`)
    } else {
        console.log('Attention, the form has not been filled out correctly!')
        emit('postFeedbackMessage', 'Attention, the form has not been filled out correctly!')
    }
}

const createForm = useForm({
    title: articleStore.title,
    subject: articleStore.subject,
    summary: articleStore.summary,
    content: articleStore.content,
    giver: articleStore.giver,
    contributors: [],
})

/** fetch data authors table */
async function fetchContributors() {
    try {
        const res = await axios.get("/contributors")
        if (res.status) {
            // console.log(res.data)
            // console.log(res.data.contributors)
            createForm.contributors = res.data?.contributors
            console.log(createForm.contributors)
        }
        // console.log(res)
    } catch (error) {
        console.log(error)
    }
}

/** if there are no errors it sends the values and clears the fields */
function submit() {
    createForm.contributors = null
    router.post("/articles", createForm)
    postMessage()
    if (fieldEmptyCheck()) {
        clearAllFieldsAndStoredData()
    }
}

/** check if the mandatory fields have been filled in */
function fieldEmptyCheck() {
    let checkField = (createForm.title != '' && createForm.subject != '' && createForm.content != '') &&
        (createForm.title != null && createForm.subject != null && createForm.content != null)
    return checkField
}

/** retains the value of title even if you change tabs */
function setStoredTitle() {
    articleStore.title = createForm.title
}

/** retains the value of subject even if you change tabs */
function setStoredSubject() {
    articleStore.subject = createForm.subject
}

/** retains the value of summary even if you change tabs */
function setStoredSummary() {
    articleStore.summary = createForm.summary
}

/** retains the value of content even if you change tabs */
function setStoredContent() {
    articleStore.content = createForm.content
}

/** retains the value of main author even if you change tabs */
function setStoredGiver() {
    articleStore.giver = createForm.giver
}

/** delete explicitly the field values from the store */
function clearStoredData() {
    articleStore.title = ''
    articleStore.subject = ''
    articleStore.summary = ''
    articleStore.content = ''
    articleStore.giver = ''
}

/** clears the form fields and the stored data */
function clearAllFieldsAndStoredData() {
    createForm.title = ''
    articleStore.title = ''
    createForm.subject = ''
    articleStore.subject = ''
    createForm.summary = ''
    articleStore.summary = ''
    createForm.content = ''
    articleStore.content = ''
    createForm.giver = ''
    articleStore.giver = ''
}
</script>

<style scoped>
/* TODO */
</style>
