<template>
    <div class="flex flex-col items-center pt-6 min-h-screen bg-gray-100 sm:justify-center sm:pt-0 dark:bg-gray-900">
        <div>
            <slot name="logo" />
        </div>

        <div
            class="overflow-hidden px-6 py-4 mt-6 w-full bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
