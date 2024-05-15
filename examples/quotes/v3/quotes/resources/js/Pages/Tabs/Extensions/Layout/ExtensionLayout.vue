<script setup>
import { defineProps } from 'vue'
import EchoIcon from '@/Icons/EchoIcon.vue'
import PostIcon from '@/Icons/PostIcon.vue'
import GetIcon from '@/Icons/GetIcon.vue'
import PostInteger from '@/Pages/Tabs/Extensions/Components/PostInteger.vue'
import EchoInteger from '@/Pages/Tabs/Extensions/Components/EchoInteger.vue'

const props = defineProps({
    value: Number
})
</script>

<template>
    <div>
        <div
            class="p-6 bg-white border-b border-gray-200 lg:p-8 dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
            <EchoIcon class="block w-auto h-12" />

            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Extension tab for testing FFI capabilities.
            </h1>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                Here are some useful extensions.
            </p>

            <p class="mt-6 leading-relaxed text-gray-500 dark:text-gray-400">
                In principle, any type of processing can be performed.
                For example: the use of system or numerical analysis libraries, or the activation of some actuator connected to the LAMP server.
            </p>
        </div>

        <div
            class="grid grid-cols-1 gap-6 p-6 bg-gray-200 bg-opacity-25 dark:bg-gray-800 md:grid-cols-2 lg:gap-8 lg:p-8">
            <div>
                <div class="flex items-center">
                    <PostIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Post Integer</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    Example of using shared libraries written in C language.
                    It simply echoes the integer typed into the input field.
                </p>

                <PostInteger />
            </div>

            <div>
                <div class="flex items-center">
                    <GetIcon class="m-2 size-6" />
                    <h2 class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                        <span>Echo Integer</span>
                    </h2>
                </div>

                <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    The value of the last integer typed in the form alongside is visible here.
                    Basic example which only serves to clarify the steps necessary to call functions written in C
                    programming language.
                    Such as, for example, the casting of data types from PHP to C and vice versa, as well as the
                    association between the underlying C function and the overlying PHP method.
                </p>

                <EchoInteger :value="props?.value" />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* TODO */
</style>
