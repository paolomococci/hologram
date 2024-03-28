<template>
    <Layout>

        <Head title="Samples" />
        <h1>Sample Index</h1>
        <SampleTable caption="fetched sample data from RDBMS" :samples="samples" />
    </Layout>
</template>

<script setup>
import Layout from './SamplesLayout.vue'
import SampleTable from './SampleTable.vue'
import { Head } from '@inertiajs/vue3'

defineProps({ samples: Array })
</script>
