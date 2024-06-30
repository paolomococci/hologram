<script setup>
defineProps({
  message: {
    type: String,
    required: true
  }
})
</script>

<template>
  <div class="greetings">
    <h1 class="green">{{ message }}</h1>
  </div>
</template>

<style scoped>
h1 {
  font-weight: 500;
  font-size: 2.6rem;
  position: relative;
  margin-left: 1rem;
  top: -10px;
}

.greetings h1 {
  text-align: center;
}

@media (max-width: 740px) {
  .greetings h1 {
    font-size: 1.5rem;
    text-align: left;
    margin-bottom: -1.5rem;
  }
}
</style>
