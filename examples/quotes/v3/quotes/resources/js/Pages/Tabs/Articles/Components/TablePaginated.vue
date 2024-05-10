<template>
    <div>
        <Pagination :links="props?.articles.links" />
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
                        <th scope="col" class="text-sm font-extralight text-left text-slate-600">
                            subject
                        </th>
                        <th v-if="thereIsSummary" scope="col" class="text-sm font-extralight text-left text-slate-600">
                            summary
                        </th>
                        <th scope="col" class="text-sm font-extralight text-left text-slate-600">
                            &#160;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-purple-100 even:bg-purple-50" v-for="article in articles.data" :key="article.id">
                        <!-- emits the identifier of the object being moused over -->
                        <td class="pl-2 text-sm font-light cursor-grabbing text-slate-300" v-text="article.id"
                            @mouseover="$emit('grabItemIdentifierFromTable', article.id)"></td>
                        <td class="text-sm font-light text-slate-600" v-text="article.title"></td>
                        <td class="text-sm font-light text-slate-600" v-text="article.subject"></td>
                        <td v-if="thereIsSummary" class="text-sm font-light text-slate-600" v-text="article?.summary">
                        </td>
                        <td v-if="article?.deprecated">
                            <SecurityIcon class="size-4" />
                        </td>
                        <td v-else>
                            &#160;
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue'
import Pagination from '@/Pages/Tabs/Common/PaginationCommon.vue'
import SecurityIcon from '@/Icons/SecurityIcon.vue'

const thereIsSummary = ref(false)

const props = defineProps({
    articles: Object,
    caption: String,
})

/** checks for the presence of the summary field */
onBeforeMount(() => {
    props.articles.data.forEach((element) => {
        thereIsSummary.value =
            element.summary != undefined || element.summary != null
    })
})
</script>

<style scoped>
/* TODO */
</style>
