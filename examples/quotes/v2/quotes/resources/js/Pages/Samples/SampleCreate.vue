<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <input
                    class="m-2 text-xs border border-purple-300 rounded-md caret-purple-700 focus:border-2 focus:border-purple-500 left-4 text-slate-500"
                    v-model.lazy="create.title"
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
                    v-model.lazy="create.subject"
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
                    v-model.lazy="create.summary"
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
                    v-model.lazy="create.content"
                    name="content"
                    id="content"
                    cols="30"
                    rows="10"
                    placeholder="Content"
                ></textarea>
            </div>
            <div>
                <button class="p-1 px-2 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm" type="submit">Save</button>
                <button class="p-1 px-2 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm" type="reset">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive } from "vue"
import { router } from "@inertiajs/vue3"

const create = reactive({
    title: null,
    subject: null,
    summary: null,
    content: null,
})

function submit() {
    router.post("/sample-create", create)
    create.title = ''
    create.subject = ''
    create.summary = ''
    create.content = ''
}
</script>
