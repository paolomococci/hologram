<template>
    <div>
        <div class="p-6 bg-white border-b border-gray-200 lg:p-8">
            <SampleIcon class="block w-auto m-6 size-12" />

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

                    <DocumentationIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Documentation</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500">
                    Some documentation text of this template.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700">
                        Explore the documentation

                        <RightArrowIcon class="size-4" />

                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">

                    <ScreenshotIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Screenshot</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500">
                    Some screenshots of this template.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700">
                        Watching screenshot

                        <RightArrowIcon class="size-4" />
                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">

                    <CommentsIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        <a href="#">Comments</a>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500">
                    Some comments provided by web application users.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700">
                        Read other users' comments

                        <RightArrowIcon class="size-4" />

                    </a>
                </p>
            </div>

            <div>
                <div class="flex items-center">

                    <SecurityIcon class="size-6" />

                    <h2 class="text-xl font-semibold text-gray-900 ms-3">
                        Web security
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500">
                    Some description of good security practices to follow when using this view template.
                </p>

                <p class="mt-4 text-sm">
                    <a href="#" class="inline-flex items-center font-semibold text-indigo-700">
                        View security practices

                        <RightArrowIcon class="size-4" />

                    </a>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import SampleIcon from '@/Icons/SampleIcon.vue'
import DocumentationIcon from '@/Icons/DocumentationIcon.vue'
import ScreenshotIcon from '@/Icons/ScreenshotIcon.vue'
import CommentsIcon from '@/Icons/CommentsIcon.vue'
import SecurityIcon from '@/Icons/SecurityIcon.vue'
import RightArrowIcon from '@/Icons/RightArrowIcon.vue'
</script>
