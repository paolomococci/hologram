<script setup>
defineProps({
  message: {
    type: String,
    required: true
  }
})
</script>

<template>
  <div>
    <h1>{{ message }}</h1>
    <h3>
      <!-- TODO -->
    </h3>
  </div>
</template>

<style scoped></style>
