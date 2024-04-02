<template>
    <div>
        <div class="relative w-16 h-16">
            <input
                v-model.lazy="filtered"
                class="absolute top-0 m-2 text-xs border border-purple-300 rounded-md caret-purple-700 focus:border-2 focus:border-purple-500 left-4 text-slate-500"
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
                ></caption>
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
                        v-for="sample in samples"
                        :key="sample.id"
                    >
                        <td
                            class="pl-2 text-sm font-light text-slate-300"
                            v-text="sample.id"
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

        <div v-if="togglePaginator">
            <button
                @click="left()"
                class="p-2 mx-1 my-4 text-sm bg-slate-200 rounded-l-xl"
            >
                <MoveLeftIcon class="size-4" />
            </button>
            <span class="text-sm text-slate-500"
                >{{ pointer + 1 }} / {{ numberOfPages }}</span
            >
            <button
                @click="right()"
                class="p-2 mx-1 my-4 text-sm bg-slate-200 rounded-r-xl"
            >
                <MoveRightIcon class="size-4" />
            </button>
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

const samples = ref()
const tuples = ref(null)
const pointer = ref(0)
const togglePaginator = ref(false)
const numberOfPages = ref(0)

/** filters the items to show based on what you type in the input element */
watch(filtered, async (query) => {
    try {
        const res = await axios.get("/sample-filter")
        const pages = []
        paginate(sieve(query, res.data), pages, 5)
        tuples.value = pages
        console.log(tuples.value[0])
        samples.value = tuples.value[0]
        togglePaginator.value = tuples.value.length > 1
        numberOfPages.value = tuples.value.length
    } catch (error) {
        statusMessage.value = "An error has occurred: " + error
    }
});

/** filter items based on title, subject and summary fields */
function sieve(query, items) {
    let filtered = new Array()
    if (query === "") {
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

/** returns a subgroup of the passed array based on the group index and size */
function subPaginate(items, index, size) {
    let end = Math.min((index + 1) * size, items.length)
    if (end % size != 0) {
        return items.slice(index * size, end)
    }
    return items.slice(Math.max(end - size, 0), end)
}

/** paging the items array into the pages array */
function paginate(items, pages, size) {
    let numberOfPages = Math.ceil(items.length / size)
    for (let i = 0; i < numberOfPages; i++) {
        pages.push(subPaginate(items, i, size))
    }
}

/** backward client side pagination */
function left() {
    --pointer.value;
    if (tuples.value != null) {
        if (pointer.value < 0) {
            pointer.value = tuples.value.length + pointer.value
        }
        console.log(pointer.value)
        console.log(tuples.value[pointer.value])
        samples.value = tuples.value[pointer.value]
    }
}

/** forward client side pagination */
function right() {
    ++pointer.value
    if (tuples.value != null) {
        if (pointer.value == tuples.value.length) {
            pointer.value = 0
        }
        console.log(pointer.value)
        console.log(tuples.value[pointer.value])
        samples.value = tuples.value[pointer.value]
    }
}
</script>