<template>
    <div>

        <div class="relative w-16 h-16">
            <input v-model.lazy="filtered"
                class="absolute top-0 left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                type="text" name="authorFilter" id="authorFilter" placeholder="Filter..." />
        </div>

        <div v-if="togglePaginator">
            <button @click="left()"
                class="p-2 mx-1 my-4 text-sm rounded-l-xl bg-slate-200 hover:shadow-md active:shadow-sm">
                <MoveLeftIcon class="size-4" />
            </button>
            <span class="text-sm text-slate-600">{{ pointer + 1 }} / {{ numberOfPages }}</span>
            <button @click="right()"
                class="p-2 mx-1 my-4 text-sm rounded-r-xl bg-slate-200 hover:shadow-md active:shadow-sm">
                <MoveRightIcon class="size-4" />
            </button>
        </div>

        <div v-if="authors" class="p-4 rounded-md bg-slate-50">
            <table class="min-w-full table-auto">
                <caption class="text-sm font-light text-center caption-top text-slate-300"></caption>
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
                        <!-- <th scope="col" class="text-sm font-extralight text-left text-slate-600">
                            email
                        </th> -->
                        <th scope="col" class="text-sm font-extralight text-left text-slate-600">
                            &#160;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-purple-100 even:bg-purple-50" v-for="author in authors" :key="author.id">
                        <!-- emits the identifier of the object being moused over -->
                        <td class="pl-2 text-sm font-light cursor-grabbing text-slate-300" v-text="author.id"
                            @mouseover="$emit('grabItemIdentifierFromTable', author.id)"></td>
                        <td class="text-sm font-light text-slate-600" v-text="author.name"></td>
                        <td class="text-sm font-light text-slate-600" v-text="author.surname"></td>
                        <!-- <td class="text-sm font-light text-slate-600" v-text="author?.email">
                        </td> -->
                        <td v-if="author?.suspended">
                            <SuspendedIcon class="size-4" />
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
import { ref, watch } from 'vue'
import axios from "axios"
import MoveLeftIcon from '@/Icons/MoveLeftIcon.vue'
import MoveRightIcon from '@/Icons/MoveRightIcon.vue'
import SuspendedIcon from '@/Icons/SuspendedIcon.vue'

const filtered = ref("")
const statusMessage = ref("")

const authors = ref()
const tuples = ref(null)
const pointer = ref(0)
const togglePaginator = ref(false)
const numberOfPages = ref(0)

/** filters the items to show based on what you type in the input element */
watch(filtered, async (query) => {
    try {
        const res = await axios.get("/authors/filter")
        console.log(res.data)
        const pages = []
        paginate(sieve(query, res.data?.authors), pages, 10)
        tuples.value = pages
        authors.value = tuples.value[0]
        togglePaginator.value = tuples.value.length > 1
        numberOfPages.value = tuples.value.length
    } catch (error) {
        statusMessage.value = "An error has occurred: " + error
    }
})

/** filter items based on name, surname and email fields */
function sieve(query, items) {
    let filtered = new Array()
    if (queryIsEmpty(query)) {
        return filtered
    }
    let queryLowerCase = query.toLowerCase()
    items.forEach((item) => {
        console.log(item)
        if (
            isInName(item.name, queryLowerCase) ||
            isInSurname(item.surname, queryLowerCase) ||
            isInEmail(item.email, queryLowerCase)
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
        authors.value = tuples.value[pointer.value]
    }
}

/** forward client side pagination */
function right() {
    ++pointer.value
    if (tuples.value != null) {
        if (pointer.value == tuples.value.length) {
            pointer.value = 0
        }
        authors.value = tuples.value[pointer.value]
    }
}

/** check if query is empty string */
function queryIsEmpty(query) {
    return query.length === 0 || query === null || query === undefined
}

/** check if the query string is present in the name */
function isInName(name, query) {
    if (name === null || email === undefined) return false
    let nameToLowerCase = name.toLowerCase()
    return nameToLowerCase.includes(query)
}

/** check if the query string is present in the surname */
function isInSurname(surname, query) {
    if (surname === null || email === undefined) return false
    let surnameToLowerCase = surname.toLowerCase()
    return surnameToLowerCase.includes(query)
}

/** check if the query string is present in the email */
function isInEmail(email, query) {
    if (email === null || email === undefined) return false
    let emailToLowerCase = email.toLowerCase()
    return emailToLowerCase.includes(query)
}
</script>

<style scoped>
/* TODO */
</style>
