<template>
    <div>
        <div class="relative w-16 h-16">
            <input v-model.lazy="filtered"
                class="absolute top-0 left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-500"
                type="text" name="articleFilter" id="articleFilter" placeholder="Filter..." />
        </div>

        <div v-if="togglePaginator">
            <button @click="left()"
                class="p-2 mx-1 my-4 text-sm rounded-l-xl bg-slate-200 hover:shadow-md active:shadow-sm">
                <MoveLeftIcon class="size-4" />
            </button>
            <span class="text-sm text-slate-500">{{ pointer + 1 }} / {{ numberOfPages }}</span>
            <button @click="right()"
                class="p-2 mx-1 my-4 text-sm rounded-r-xl bg-slate-200 hover:shadow-md active:shadow-sm">
                <MoveRightIcon class="size-4" />
            </button>
        </div>

        <div v-if="articles" class="p-4 rounded-md bg-slate-50">
            <table class="min-w-full table-auto">
                <caption class="text-sm font-light text-center caption-top text-slate-300"></caption>
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
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-purple-100 even:bg-purple-50" v-for="article in articles" :key="article.id">
                        <!-- emits the identifier of the object being moused over -->
                        <td class="pl-2 text-sm font-light cursor-grabbing text-slate-300" v-text="article.id"
                            @mouseover="
                                $emit(
                                    'grabItemIdentifierFromCarousel',
                                    article.id
                                )
                                "></td>
                        <td class="text-sm font-light text-slate-500" v-text="article.title"></td>
                        <td class="text-sm font-light text-slate-500" v-text="article.subject"></td>
                        <td v-if="thereIsSummary" class="text-sm font-light text-slate-500" v-text="article?.summary">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script setup>
import { ref, watch } from "vue"
import axios from "axios"
import MoveLeftIcon from "@/Icons/MoveLeftIcon.vue"
import MoveRightIcon from "@/Icons/MoveRightIcon.vue"

const filtered = ref("")
const statusMessage = ref("")

const articles = ref()
const tuples = ref(null)
const pointer = ref(0)
const togglePaginator = ref(false)
const numberOfPages = ref(0)

/** filters the items to show based on what you type in the input element */
watch(filtered, async (query) => {
    try {
        const res = await axios.get("/articles/filter")
        console.log(res.data)
        const pages = []
        paginate(sieve(query, res.data?.articles), pages, 10)
        tuples.value = pages
        // console.log(tuples.value[0])
        articles.value = tuples.value[0]
        togglePaginator.value = tuples.value.length > 1
        numberOfPages.value = tuples.value.length
    } catch (error) {
        statusMessage.value = "An error has occurred: " + error
    }
})

/** filter items based on title, subject and summary fields */
function sieve(query, items) {
    let filtered = new Array()
    if (queryIsEmpty(query)) {
        return filtered
    }
    let queryLowerCase = query.toLowerCase()
    items.forEach((item) => {
        console.log(item)
        if (
            isInTitle(item.title, queryLowerCase) ||
            isInSubject(item.subject, queryLowerCase) ||
            isInSummary(item.summary, queryLowerCase)
        ) {
            filtered.push(item)
        }
    })
    return filtered
}

/** returns a subgroup of the passed array based on the group index and size */
function subPaginate(items, index, size) {
    let end = Math.min((index + 1) * size, items.length)
    if (end % size != 0) {
        return items.slice(index * size, end)
    }
    return items.slice(Math.max(end - size, 0), end)
}

/** paging the items array into the pages array, the size parameter determines the number of items on the page */
function paginate(items, pages, size) {
    let numberOfPages = Math.ceil(items.length / size)
    for (let i = 0; i < numberOfPages; i++) {
        pages.push(subPaginate(items, i, size))
    }
}

/** backward client side pagination */
function left() {
    --pointer.value
    if (tuples.value != null) {
        if (pointer.value < 0) {
            pointer.value = tuples.value.length + pointer.value
        }
        // console.log(pointer.value)
        // console.log(tuples.value[pointer.value])
        articles.value = tuples.value[pointer.value]
    }
}

/** forward client side pagination */
function right() {
    ++pointer.value
    if (tuples.value != null) {
        if (pointer.value == tuples.value.length) {
            pointer.value = 0
        }
        // console.log(pointer.value)
        // console.log(tuples.value[pointer.value])
        articles.value = tuples.value[pointer.value]
    }
}

/** check if query is empty string */
function queryIsEmpty(query) {
    return query.length === 0 || query === null || query === undefined
}

/** check if the query string is present in the title */
function isInTitle(title, query) {
    if (title === null || summary === undefined) return false
    let titleToLowerCase = title.toLowerCase()
    return titleToLowerCase.includes(query)
}

/** check if the query string is present in the subject */
function isInSubject(subject, query) {
    if (subject === null || summary === undefined) return false
    let subjectToLowerCase = subject.toLowerCase()
    return subjectToLowerCase.includes(query)
}

/** check if the query string is present in the summary */
function isInSummary(summary, query) {
    if (summary === null || summary === undefined) return false
    let summaryToLowerCase = summary.toLowerCase()
    return summaryToLowerCase.includes(query)
}
</script>

<style scoped>
/* TODO */
</style>
