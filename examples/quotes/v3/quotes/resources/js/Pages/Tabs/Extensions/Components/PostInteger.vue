<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.value" size="30" type="text" name="value" id="value" placeholder="a value between one and one-thousand"
                    required minlength="1" maxlength="10" />
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
                    type="submit" :disabled="createForm.processing">Post</button>
                <button
                    class="p-1 px-2 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm"
                    type="reset">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
// import { reactive } from 'vue' // at least for the moment I replace `reactive` with `useForm`
import { router, useForm } from "@inertiajs/vue3"

const createForm = useForm({
    value: null,
})

/** if there are no errors it sends the values and clears the fields */
function submit() {
    router.post("/echo", createForm)
    if (fieldEmptyCheck()) {
        createForm.value = ''
    }
}

/** check if the mandatory fields have been filled in */
function fieldEmptyCheck() {
    let checkField = (createForm.value != '') && (createForm.value != null)
    return checkField
}
</script>

<style scoped>
/* TODO */
</style>
