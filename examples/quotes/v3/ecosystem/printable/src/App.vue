<script setup>
import HeadMessage from './components/HeadMessage.vue'
import MainView from './components/MainView.vue'
</script>

<template>
  <header>
    <div>
      <HeadMessage message="Welcome to Printable micro-frontend!" />
    </div>
  </header>

  <main>
    <MainView />
  </main>
</template>

<style scoped></style>
