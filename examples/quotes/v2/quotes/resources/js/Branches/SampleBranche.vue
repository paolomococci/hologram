<template>
    <div>
        <div class="p-6 bg-white border-b border-gray-200 lg:p-8">
            <WithCautionIcon class="block w-auto m-6 size-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Sample of view template!
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500">
                A simple description that introduces the user how to use this template tab.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">

                    <AddElementIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Create</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500">
                    How to insert data of new sample element.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700">
                        Add new sample in full screen mode

                        <RightArrowIcon class="size-4" />

                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">

                    <FetchDataIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Read All</a>
                    </h2>
                </div>

                <SampleTable caption="fetched sample data from RDBMS" :samples="samples" />

                <p class="mt-4 text-sm">
                    <a :href="sampleIndexUrl" target="_blank" class="inline-flex items-center font-semibold text-indigo-700">
                        Fetch sample data table in full screen mode

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">

                    <EditElementIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Edit</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500">
                    Edit selected sample.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700">
                        Edit selected sample in full screen mode

                        <RightArrowIcon class="size-4" />

                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">

                    <DutyAttentionIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        Deprecate
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500">
                    Some description to deprecate a sample item.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700">
                        Deprecate obsolete sample

                        <RightArrowIcon class="size-4" />

                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import WithCautionIcon from '@/Icons/WithCautionIcon.vue'
import AddElementIcon from '@/Icons/AddElementIcon.vue'
import FetchDataIcon from '@/Icons/FetchDataIcon.vue'
import EditElementIcon from '@/Icons/EditElementIcon.vue'
import DutyAttentionIcon from '@/Icons/DutyAttentionIcon.vue'
import RightArrowIcon from '@/Icons/RightArrowIcon.vue'
import SampleTable from '@/Pages/Samples/SampleTable.vue'
import { BASE } from '@/env.js'

const props = defineProps(['samples'])
const sampleIndexUrl = BASE + 'sample-index'
</script>
