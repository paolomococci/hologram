<template>

    <div class="mt-4 text-sm leading-relaxed text-gray-500">
        <ul>
            <li>ID: {{ page.props.auth.user.id }}</li>
            <li>Name: {{ page.props.auth.user.name }}</li>
            <li>Email: {{ page.props.auth.user.email }}</li>
            <li>Registered on: {{ page.props.auth.user.created_at }}</li>
        </ul>
    </div>

</template>

<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()
</script>
