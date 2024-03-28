<template>
    <div>
        <table class="min-w-full table-auto">
            <caption class="text-sm font-light text-center caption-top text-slate-300">{{ caption }}</caption>
            <thead class="border-b bg-slate-50">
                <tr>
                    <th scope="col" class="text-sm text-left font-extralight text-slate-600">title</th>
                    <th scope="col" class="text-sm text-left font-extralight text-slate-600">subject</th>
                </tr>
            </thead>
            <tbody>
                <tr class="odd:bg-purple-100 even:bg-purple-50" v-for="sample in samples" :key="sample.id">
                <td class="text-sm font-light text-slate-500">{{ sample.title }}</td>
                <td class="text-sm font-light text-slate-500">{{ sample.subject }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
const props = defineProps(['caption', 'samples'])
console.log(props?.caption)
console.log(props?.samples)
</script>
