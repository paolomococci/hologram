<script setup>
import HeadMessage from './components/HeadMessage.vue'
import MainView from './components/MainView.vue'
</script>

<template>
  <div class="container min-w-full min-h-screen bg-slate-900">
    <header class="bg-slate-700">
      <div>
        <HeadMessage message="Quotes Printable" />
      </div>
    </header>

    <main>
      <MainView />
    </main>
  </div>
</template>

<style scoped>
header {
  position: sticky;
  top: 0;
  z-index: 999;
}

main {
  overflow: hidden;
}
</style>
