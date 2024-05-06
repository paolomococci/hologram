<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <div v-if="errors.title" class="content-center pt-2 text-xs rounded-md">
                    <p class="text-red-700">{{ errors.title }}</p>
                </div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-500"
                    v-model.lazy="createForm.title"
                    size="30"
                    type="text"
                    name="title"
                    id="title"
                    placeholder="Title"
                />
            </div>
            <div>
                <div v-if="errors.subject" class="content-center pt-2 text-xs rounded-md">
                    <p class="text-red-700">{{ errors.subject }}</p>
                </div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-500"
                    v-model.lazy="createForm.subject"
                    size="30"
                    type="text"
                    name="subject"
                    id="subject"
                    placeholder="Subject"
                />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-500"
                    v-model.lazy="createForm.summary"
                    size="30"
                    type="text"
                    name="summary"
                    id="summary"
                    placeholder="Summary"
                />
            </div>
            <div>
                <div v-if="errors.content" class="content-center pt-2 text-xs rounded-md">
                    <p class="text-red-700">{{ errors.content }}</p>
                </div>
                <textarea
                    class="left-4 m-2 max-h-60 text-xs rounded-md border border-purple-300 min-h-36 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-500"
                    v-model.lazy="createForm.content"
                    name="content"
                    id="content"
                    cols="30"
                    rows="10"
                    placeholder="Content"
                ></textarea>
            </div>
            <div>
                <button
                    class="p-1 px-2 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm"
                    type="submit">Save</button>
                <button
                    class="p-1 px-2 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm"
                    type="reset">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, defineProps } from 'vue'
import { router } from "@inertiajs/vue3"

const props = defineProps({
    errors: Object
})

const createForm = reactive({
    title: null,
    subject: null,
    summary: null,
    content: null,
})

/** if there are no errors it sends the values and clears the fields */
function submit() {
    router.post("/articles", createForm)
    if (fieldEmptyCheck()) {
        createForm.title = ''
        createForm.subject = ''
        createForm.summary = ''
        createForm.content = ''
    }
}

/** check if the mandatory fields have been filled in */
function fieldEmptyCheck() {
    let checkField = (createForm.title != '' && createForm.subject != '' && createForm.content != '') &&
        (createForm.title != null && createForm.subject != null && createForm.content != null)
    return checkField
}
</script>

<style scoped>
/* TODO */
</style>
