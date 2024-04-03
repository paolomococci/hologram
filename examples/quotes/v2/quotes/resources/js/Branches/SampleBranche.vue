<template>
    <div>
        <div class="p-6 bg-white border-b border-gray-200 lg:p-8">
            <WithCautionIcon class="block w-auto m-6 size-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Sample of view template!
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500">
                A simple description that introduces the user how to use this
                template tab.
            </p>
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 md:grid-cols-2 lg:gap-8 lg:p-8"
        >
            <div>
                <div class="flex items-center">
                    <AddElementIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Create</a>
                    </h2>
                </div>

                <SampleCreate />

            </div>

            <div>
                <div class="flex items-center">
                    <FetchDataIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Read All</a>
                    </h2>
                </div>

                <!-- intercepts and transmits the identifier of the object over which the mouse is hovered -->
                <SampleTable
                    caption="fetched sample data from RDBMS"
                    :samples="samples"
                    @grabItemIdentifierFromTable="(id) => retransmitItemIdentifier(id)"
                />

            </div>

            <div>
                <div class="flex items-center">
                    <EditElementIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Edit</a>
                    </h2>
                </div>

                <div v-if="editorOneIsVisible">
                    <SampleEdit :itemId="itemId" />
                </div>

                <div v-if="editorTwoIsVisible">
                    <SampleEdit :itemId="itemId" />
                </div>

            </div>

            <div>
                <div class="flex items-center">
                    <FilterElementIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        Filter
                    </h2>
                </div>

                <!-- intercepts and transmits the identifier of the object over which the mouse is hovered -->
                <SampleCarousel @grabItemIdentifierFromCarousel="(id) => retransmitItemIdentifier(id)" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { BASE } from "@/env.js"
import { ref } from "vue"

import WithCautionIcon from "@/Icons/WithCautionIcon.vue"
import AddElementIcon from "@/Icons/AddElementIcon.vue"
import FetchDataIcon from "@/Icons/FetchDataIcon.vue"
import EditElementIcon from "@/Icons/EditElementIcon.vue"
import FilterElementIcon from "@/Icons/FilterElementIcon.vue"
import SampleCreate from "@/Pages/Samples/SampleCreate.vue"
import SampleEdit from "@/Pages/Samples/SampleEdit.vue"
import SampleTable from "@/Pages/Samples/SampleTable.vue"
import SampleCarousel from "@/Pages/Samples/SampleCarousel.vue"

defineProps({ samples: Object })
const sampleIndexUrl = BASE + "sample-index"

const itemId = ref(0)
const editorOneIsVisible = ref(true)
const editorTwoIsVisible = ref(false)

function retransmitItemIdentifier(id) {
    itemId.value = id
    toggleEditor()
}

function toggleEditor() {
    editorOneIsVisible.value = !editorOneIsVisible.value
    editorTwoIsVisible.value = !editorTwoIsVisible.value
}
</script>
