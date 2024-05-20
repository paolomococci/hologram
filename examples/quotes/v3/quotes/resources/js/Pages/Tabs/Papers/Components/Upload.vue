<template>
    <div>
        <h3 class="p-4 m-4 text-center">TODO</h3>
        <form @submit.prevent="submit">
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="uploadForm.filename" size="30" type="text" name="filename" id="filename"
                    placeholder="Filename" required />
            </div>
            <div class="left-4 pb-4 m-2">
                <input
                    class="block w-full text-xs text-slate-200 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-300"
                    @input="uploadForm.scanned = $event.target.files[0]" size="30" type="file" name="scanned"
                    id="scanned" placeholder="Scanned" required />
            </div>
            <div>
                <progress class="mb-4 w-full h-1 bg-purple-400 rounded-lg dark:bg-purple-600" v-if="uploadForm.progress"
                    :value="uploadForm.progress.percentage" max="100">
                    {{ uploadForm.progress.percentage }}%
                </progress>
            </div>
            <div>
                <button
                    class="p-1 px-2 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm"
                    type="submit" :disabled="uploadForm.processing">Save</button>
                <button
                    class="p-1 px-2 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm"
                    type="reset">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const uploadForm = useForm({
    filename: null,
    scanned: null
})

function submit() {
    uploadForm.post('/papers')
}
</script>

<style scoped>
/* TODO */
</style>
