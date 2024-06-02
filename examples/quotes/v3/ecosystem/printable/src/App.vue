<script setup>
import HeadMessage from './components/HeadMessage.vue'
import MainView from './components/MainView.vue'
</script>

<template>
  <header class="p-4 m-4 rounded-lg bg-slate-700">
    <div>
      <HeadMessage message="Quotes Printable" />
    </div>
  </header>

  <main>
    <MainView />
  </main>
</template>

<style scoped></style>
