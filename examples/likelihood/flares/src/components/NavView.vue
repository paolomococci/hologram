<script setup>
import NavItem from './NavItem.vue'
import HelpIcon from './icons/HelpIcon.vue'
import UploadIcon from './icons/UploadIcon.vue'
import EstimateIcon from './icons/EstimateIcon.vue'
import AttachIcon from './icons/AttachIcon.vue'
import PlaygroundIcon from './icons/PlaygroundIcon.vue'
import CogIcon from './icons/CogIcon.vue'
import { RouterLink } from 'vue-router'
import {
  uploadMessageStore,
  ponderMessageStore,
  clipMessageStore,
  estimateMessageStore,
  playgroundMessageStore
} from '@/stores/feedbackStore'

const uploadMessages = uploadMessageStore()
const ponderMessages = ponderMessageStore()
const clipMessages = clipMessageStore()
const estimateMessages = estimateMessageStore()
const playgroundMessages = playgroundMessageStore()
</script>

<template>
  <NavItem>
    <template #icon>
      <RouterLink to="/">
        <HelpIcon />
      </RouterLink>
    </template>
    <template #label>&#160;</template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/upload">
        <UploadIcon />
      </RouterLink>
    </template>
    <template #label>&#160;
      <span class="resultMessage" v-text="uploadMessages.resultMessage"></span>
      <div v-if="uploadMessages.rangeErrorMessage.length > 0" :title="uploadMessages.rangeErrorMessage.toString()">
        <ol class="errorMessage">
          <li>{{ uploadMessages.rangeErrorMessage[0] }}</li>
        </ol>
      </div>
      <span class="errorMessage" v-text="uploadMessages.errorMessage"></span>
    </template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/ponder">
        <CogIcon />
      </RouterLink>
    </template>
    <template #label>&#160;
      <span class="resultMessage" v-text="ponderMessages.resultMessage"></span>
      <span class="errorMessage" v-text="ponderMessages.errorMessage"></span>
      <span class="spinnerInProcess" :style="ponderMessages.inProcess">
        <i class="pi pi-spin pi-spinner"></i>
      </span>
    </template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/clip">
        <AttachIcon />
      </RouterLink>
    </template>
    <template #label>&#160;
      <span class="resultMessage" v-text="clipMessages.resultMessage"></span>
      <span class="errorMessage" v-text="clipMessages.errorMessage"></span>
    </template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/estimate">
        <EstimateIcon />
      </RouterLink>
    </template>
    <template #label>&#160;
      <span class="resultMessage" v-if="estimateMessages.resultMessage">
        The hypothesized coordinates of the next flare are as follows:
      </span>
      <span class="resultMessage" v-if="estimateMessages.resultMessage">
        from left to right, width, height, depth, virtual and folding time.
      </span>
      <span class="resultMessage" v-text="estimateMessages.resultMessage"></span>
      <span class="alertMessage" v-text="estimateMessages.alertMessage"></span>
      <span class="errorMessage" v-text="estimateMessages.errorMessage"></span>
    </template>
  </NavItem>

  <NavItem>
    <template #icon>
      <RouterLink to="/playground">
        <PlaygroundIcon />
      </RouterLink>
    </template>
    <template #label>&#160;
      <span class="resultMessage" v-text="playgroundMessages.resultMessage"></span>
      <span class="errorMessage" v-text="playgroundMessages.errorMessage"></span>
    </template>
  </NavItem>
</template>

<style scoped>
ol,
ul {
  list-style-type: none;
}

li {
  display: inline;
}

.resultMessage {
  color: #3e0;
  font-family: monospace;
  font-weight: 500;
  margin-top: 0.5rem;
  padding: 1rem;
  text-align: center;
  display: inline-flex;
}

.errorMessage {
  color: #f00;
  font-family: monospace;
  font-weight: 700;
  margin-top: 0.5rem;
  padding: 1rem;
  text-align: center;
  display: inline-flex;
}

.alertMessage {
  color: #fe0;
  font-family: monospace;
  font-weight: 700;
  margin-top: 0.5rem;
  padding: 1rem;
  text-align: center;
  display: inline-flex;
}

.spinnerInProcess {
  font-size: 3rem;
  color: #0b7;
  text-align: center;
  /* display: none; */
}

@media (max-width: 1024px) {

  .errorMessage,
  .resultMessage {
    display: none;
  }
}
</style>
