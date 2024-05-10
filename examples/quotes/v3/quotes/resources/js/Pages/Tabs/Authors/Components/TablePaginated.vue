<template>
    <div>
        <Pagination :links="props?.authors.links" />
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
                            name
                        </th>
                        <th scope="col" class="text-sm font-extralight text-left text-slate-600">
                            surname
                        </th>
                        <!-- <th v-if="thereIsEmail" scope="col" class="text-sm font-extralight text-left text-slate-600">
                            email
                        </th> -->
                        <th scope="col" class="text-sm font-extralight text-left text-slate-600">
                            &#160;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-purple-100 even:bg-purple-50" v-for="author in authors.data" :key="author.id">
                        <!-- emits the identifier of the object being moused over -->
                        <td class="pl-2 text-sm font-light cursor-grabbing text-slate-300" v-text="author.id"
                            @mouseover="$emit('grabItemIdentifierFromTable', author.id)"></td>
                        <td class="text-sm font-light text-slate-600" v-text="author.name"></td>
                        <td class="text-sm font-light text-slate-600" v-text="author.surname"></td>
                        <!-- <td v-if="thereIsEmail" class="text-sm font-light text-slate-600" v-text="author?.email">
                        </td> -->
                        <td v-if="author?.suspended">
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

const thereIsEmail = ref(false)

const props = defineProps({
    authors: Object,
    caption: String,
})

/** checks for the presence of the email field */
onBeforeMount(() => {
    props.authors.data.forEach((element) => {
        thereIsEmail.value =
            element.email != undefined || element.email != null
    })
})
</script>

<style scoped>
/* TODO */
</style>
