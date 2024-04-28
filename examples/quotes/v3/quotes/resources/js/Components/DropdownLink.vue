<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    as: String,
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" type="submit"
            class="block px-4 py-2 w-full text-sm leading-5 text-gray-700 transition duration-150 ease-in-out text-start dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
            <slot />
        </button>

        <a v-else-if="as == 'a'" :href="href"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
            <slot />
        </a>

        <Link v-else :href="href"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
        <slot />
        </Link>
    </div>
</template>
