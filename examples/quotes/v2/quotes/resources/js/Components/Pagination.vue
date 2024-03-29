<template>
    <div class="mt-2">
        <a
            :is="link.url ? 'a' : 'span'"
            v-for="link in links"
            :href="link.url"
            v-html="link.label"
            class="inline p-2"
            :class="{
                'text-slate-500': !link.url,
                'text-purple-300': link.url,
                'font-bold': link.active,
            }"
        >
        </a>
    </div>
</template>

<script setup>
defineProps({ links: Array });
</script>
