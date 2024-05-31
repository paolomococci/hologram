<script setup>
import HeadMessage from './components/HeadMessage.vue'
import MainView from './components/MainView.vue'
</script>

<template>
  <header class="bg-gray-500">
    <div>
      <HeadMessage message="Welcome to Printable micro-frontend!" />
    </div>
  </header>

  <main class="bg-gray-700">
    <MainView />
  </main>
</template>

<style scoped></style>
