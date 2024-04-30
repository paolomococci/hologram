<script setup>
import { Link } from '@inertiajs/vue3'
import ReturnBackIcon from '@/Icons/ReturnBackIcon.vue'
</script>

<template>
    <div class="p-2 m-2 rounded-full bg-slate-300 hover:bg-purple-300">
        <Link :href="'/'">
        <ReturnBackIcon class="m-2 size-16" />
        </Link>
    </div>
</template>
