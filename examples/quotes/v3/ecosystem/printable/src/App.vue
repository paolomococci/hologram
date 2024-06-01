<script setup>
import HeadMessage from './components/HeadMessage.vue'
import MainView from './components/MainView.vue'
</script>

<template>
  <header class="bg-slate-700 m-4 p-4 rounded-lg">
    <div>
      <HeadMessage message="Quotes Printable" />
    </div>
  </header>

  <main>
    <MainView />
  </main>
</template>

<style scoped></style>
