<template>
    <div>
        <Pagination :links="props?.papers.links" />
        <div class="p-4 rounded-md bg-slate-50">
            <table class="min-w-full table-auto">
                <caption class="text-sm font-light text-center caption-top text-slate-300">
                    {{
                        caption
                    }}
                </caption>
                <thead class="border-b bg-slate-50">
                    <tr>
                        <th scope="col" class="pl-2 text-sm font-extralight text-left text-slate-400">
                            #
                        </th>
                        <th scope="col" class="text-sm font-extralight text-left text-slate-600">
                            title
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-purple-100 even:bg-purple-50" v-for="paper in papers.data" :key="paper.id">
                        <!-- emits the identifier of the object being moused over -->
                        <td class="pl-2 text-sm font-light cursor-grabbing text-slate-300" v-text="paper.id"
                            @mouseover="$emit('grabItemIdentifierFromTable', paper.id)"></td>
                        <td class="text-sm font-light text-slate-600" v-text="paper.title"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import Pagination from '@/Pages/Tabs/Common/PaginationCommon.vue'

const props = defineProps({
    papers: Object,
    caption: String,
})
</script>

<style scoped>
/* TODO */
</style>
