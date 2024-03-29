<template>
    <div>
        <table class="min-w-full table-auto">
            <caption class="text-sm font-light text-center caption-top text-slate-300">{{ caption }}</caption>
            <thead class="border-b bg-slate-50">
                <tr>
                    <th scope="col" class="text-sm text-left font-extralight text-slate-600">title</th>
                    <th scope="col" class="text-sm text-left font-extralight text-slate-600">subject</th>
                    <th v-if="thereIsSummary" scope="col" class="text-sm text-left font-extralight text-slate-600">summary</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-purple-100 even:bg-purple-50" v-for="sample in samples" :key="sample.id">
                <td class="text-sm font-light text-slate-500" v-text="sample.title"></td>
                <td class="text-sm font-light text-slate-500" v-text="sample.subject"></td>
                <td v-if="thereIsSummary" class="text-sm font-light text-slate-500" v-text="sample?.summary"></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue"

const thereIsSummary = ref(false)
const props = defineProps(['caption', 'samples'])

onBeforeMount(() => {
    props.samples.forEach(element => {
        thereIsSummary.value = (element.summary != undefined || element.summary != null)
    })
console.log('there is a summary: ' + thereIsSummary.value)
})

console.log('caption: ' + props?.caption)
console.log('samples: ' + props?.samples.length)
console.log(props?.samples)
</script>
