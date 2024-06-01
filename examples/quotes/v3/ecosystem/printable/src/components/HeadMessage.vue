<script setup>
defineProps({
  message: {
    type: String,
    required: true
  }
})
</script>

<template>
  <div class="card">
    <h1 class="text-xl text-slate-400 indent-8">{{ message }}</h1>
    <h3>
      <!-- TODO -->
    </h3>
  </div>
</template>

<style scoped></style>
