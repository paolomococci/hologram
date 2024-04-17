<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <input
                    class="m-2 text-xs border border-purple-300 rounded-md caret-purple-700 focus:border-2 focus:border-purple-500 left-4 text-slate-500"
                    v-model.lazy="editForm.id"
                    size="30"
                    type="text"
                    name="id"
                    id="id"
                    placeholder="#"
                    readonly
                />
            </div>
            <div>
                <input
                    class="m-2 text-xs border border-purple-300 rounded-md caret-purple-700 focus:border-2 focus:border-purple-500 left-4 text-slate-500"
                    v-model.lazy="editForm.title"
                    size="30"
                    type="text"
                    name="title"
                    id="title"
                    placeholder="Title"
                />
            </div>
            <div>
                <input
                    class="m-2 text-xs border border-purple-300 rounded-md caret-purple-700 focus:border-2 focus:border-purple-500 left-4 text-slate-500"
                    v-model.lazy="editForm.subject"
                    size="30"
                    type="text"
                    name="subject"
                    id="subject"
                    placeholder="Subject"
                />
            </div>
            <div>
                <input
                    class="m-2 text-xs border border-purple-300 rounded-md caret-purple-700 focus:border-2 focus:border-purple-500 left-4 text-slate-500"
                    v-model.lazy="editForm.summary"
                    size="30"
                    type="text"
                    name="summary"
                    id="summary"
                    placeholder="Summary"
                />
            </div>
            <div>
                <textarea
                    class="m-2 text-xs border border-purple-300 rounded-md max-h-60 min-h-36 caret-purple-700 focus:border-2 focus:border-purple-500 left-4 text-slate-500"
                    v-model.lazy="editForm.content"
                    name="content"
                    id="content"
                    cols="30"
                    rows="10"
                    placeholder="Content"
                ></textarea>
            </div>
            <div>
                <button class="px-2 py-1 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm" type="submit">Save</button>
                <button class="px-2 py-1 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm" type="reset">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, onBeforeMount } from "vue"
import { router } from "@inertiajs/vue3"
import axios from "axios"

const props = defineProps({
    itemId: String
})

onBeforeMount(() => {
    fetchDataItem(props?.itemId)
})

const editForm = reactive({
    id: null,
    title: null,
    subject: null,
    summary: null,
    content: null,
})

/** sends the values and clears the fields */
function submit() {
    if (fieldEmptyCheck()) {
        router.post("/sample-edit", editForm)
        editForm.id = '#'
        editForm.title = ''
        editForm.subject = ''
        editForm.summary = ''
        editForm.content = ''
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
            const res = await axios.get("/sample-read/" + id)
            if (res.status) {
                console.log(res.data)
                editForm.id = res.data.id
                editForm.title = res.data.title
                editForm.subject = res.data.subject
                editForm.summary = res.data?.summary
                editForm.content = res.data.content
            }
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
</script>
