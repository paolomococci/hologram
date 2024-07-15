<template>
  <div class="right-view">
    <section>
      <h1 class="headingOne">Playground</h1>
      <h3 class="headingThree">test the mentis hard code</h3>
      <p>
        Test desk to allow you to choose which one to codify to have reliable estimates.
      </p>
      <form @submit.prevent="onSubmit" id="playgroundForm" name="playgroundForm" action="" method="post"
        enctype="multipart/form-data">
        <input @click="playground()" type="submit" value="PLAY">
        <span id="inProcess">
          <i class="pi pi-spin pi-spinner"></i>
        </span>
      </form>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { playgroundMessageStore } from '@/stores/feedbackStore'

const playgroundMessages = playgroundMessageStore()

const mentis = ref('')

function playground() {
  console.log('Playground TODO')
  playgroundMessages.resultMessage = 'Playground TODO'
}
</script>

<style>
h1 {
  font-weight: 500;
  margin-bottom: 0.5rem;
  color: var(--color-heading);
}

h3 {
  font-weight: 500;
  margin-bottom: 0.4rem;
  color: var(--color-heading);
}

input {
  padding: 0.5rem;
  color: #032;
  background-color: #999;
  border: thin solid #333;
  border-radius: 0.5rem;
  transition: 1s;
  cursor: pointer;
}

input:hover {
  background-color: #0b7;
  box-shadow: 0.25rem 0.25rem 0.75rem #003;
}

input[type="file"]::file-selector-button {
  font-family: monospace;
  padding: 0.5rem;
  color: #032;
  background-color: #999;
  border: thin solid #333;
  margin-right: 1rem;
  border-radius: 0.75rem;
  transition: 0.5s;
  cursor: pointer;
}

input[type="file"]::file-selector-button:hover {
  background-color: #0b9;
  box-shadow: 0.25rem 0.25rem 0.75rem #333;
}

#playgroundForm {
  display: grid;
  gap: 0.5rem;
  margin-top: 1rem;
}

#inProcess {
  font-size: 3rem;
  color: #0b7;
  text-align: center;
  display: none;
}

@media (min-width: 1024px) {
  .right-view {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
