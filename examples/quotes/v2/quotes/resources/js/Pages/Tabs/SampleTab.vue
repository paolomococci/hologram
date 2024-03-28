<template>
    <AppLayout title="Sample">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Sample
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <SampleBranche :samples="samples" />
                </div>
            </div>
        </div>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import SampleBranche from '@/Branches/SampleBranche.vue'

// defineProps({ samples: Array })
const props = defineProps(['samples'])
</script>
