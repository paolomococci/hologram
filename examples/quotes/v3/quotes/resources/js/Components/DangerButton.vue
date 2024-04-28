<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type"
        class="inline-flex justify-center items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-red-600 rounded-md border border-transparent transition duration-150 ease-in-out hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
        <slot />
    </button>
</template>
