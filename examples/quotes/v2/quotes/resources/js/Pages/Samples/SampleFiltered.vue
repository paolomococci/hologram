<template>
    <div>
        <div class="relative w-16 h-16">
            <input
                v-model.lazy="filtered"
                class="absolute top-0 m-2 text-xs border border-purple-300 rounded-md focus:border-2 focus:border-purple-500 left-4 text-slate-500"
                type="text"
                name="sampleFilter"
                id="sampleFilter"
                placeholder="Filter..."
            />
        </div>
        <div>
            <table class="min-w-full table-auto">
                <caption
                    class="text-sm font-light text-center caption-top text-slate-300"
                >
                    filtered
                </caption>
                <thead class="border-b bg-slate-50">
                    <tr>
                        <th
                            scope="col"
                            class="text-sm text-left font-extralight text-slate-600"
                        >
                            title
                        </th>
                        <th
                            scope="col"
                            class="text-sm text-left font-extralight text-slate-600"
                        >
                            subject
                        </th>
                        <th
                            v-if="thereIsSummary"
                            scope="col"
                            class="text-sm text-left font-extralight text-slate-600"
                        >
                            summary
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="odd:bg-purple-100 even:bg-purple-50"
                        v-for="sample in samples"
                        :key="sample.id"
                    >
                        <td
                            class="text-sm font-light text-slate-500"
                            v-text="sample.title"
                        ></td>
                        <td
                            class="text-sm font-light text-slate-500"
                            v-text="sample.subject"
                        ></td>
                        <td
                            v-if="thereIsSummary"
                            class="text-sm font-light text-slate-500"
                            v-text="sample?.summary"
                        ></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue"
import axios from "axios"

const filtered = ref('')
const statusMessage = ref('')
const samples = ref()

watch(filtered, async (query) => {
    try {
        const res = await axios.get("/sample-filter")
        samples.value = sieve(query, res.data)
    } catch (error) {
        statusMessage.value = "An error has occurred: " + error
    }
})

function sieve(query, items) {
    let filtered = new Array()
    if (query === '') {
        return filtered
    }
    items.forEach((item) => {
        if (
            item.title.toLowerCase().includes(query.toLowerCase()) ||
            item.subject.toLowerCase().includes(query.toLowerCase()) ||
            item.summary.toLowerCase().includes(query.toLowerCase())
        ) {
            filtered.push(item)
        }
    })
    return filtered
}
</script>
