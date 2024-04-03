<template>
    <div>
        <div>
            <table class="min-w-full table-auto">
                <caption
                    class="text-sm font-light text-center caption-top text-slate-300"
                >
                    {{
                        caption
                    }}
                </caption>
                <thead class="border-b bg-slate-50">
                    <tr>
                        <th
                            scope="col"
                            class="pl-2 text-sm text-left font-extralight text-slate-400"
                        >
                            #
                        </th>
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
                        v-for="sample in samples.data"
                        :key="sample.id"
                    >
                        <!-- emits the identifier of the object being moused over -->
                        <td
                            class="pl-2 text-sm font-light cursor-grabbing text-slate-300"
                            v-text="sample.id"
                            @mouseover="$emit('grabItemIdentifierFromTable', sample.id)"
                        ></td>
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
        <Pagination :links="props?.samples.links" />
    </div>
</template>

<script setup>
import { onBeforeMount, ref } from "vue"
import Pagination from "@/Components/Pagination.vue"

const thereIsSummary = ref(false)

const props = defineProps({
    samples: Object,
    caption: String,
})

/** checks for the presence of the summary field */
onBeforeMount(() => {
    props.samples.data.forEach((element) => {
        thereIsSummary.value =
            element.summary != undefined || element.summary != null
    })
})

/** grab id of element */
function currentIdentifier(id) {
    console.log(id)
}
</script>
