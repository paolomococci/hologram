<template>
  <div class="right-view">
    <section>
      <h1 class="headingOne">Clip</h1>
      <h3 class="headingThree">please you choose a forma-mentis</h3>
      <p>
        Please, now it would be necessary to load a forma-mentis of your choice from those previously processed and
        saved locally.
      </p>
      <p>
        Thank you.
      </p>
      <form class="flaresForm" @submit.prevent="onSubmit" id="clipFormaMentis" name="clipFormaMentis"
        enctype="multipart/form-data">
        <label for="jsonFormaMentis">Choose a JSON forma-mentis file</label>
        <input type="file" name="jsonFormaMentis" id="jsonFormaMentis" accept="application/json">
        <input class="submitForm" @click="clipFormaMentis()" type="submit" value="CHOOSE">
        <input type="reset" value="RESET">
        <p class="resultMessage" id="feedbackMessage"></p>
        <p class="alertMessage" id="alertMessage"></p>
      </form>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { formaMentisStore } from '@/stores/mentisStore'
import { commonCheckStore, clipMessageStore, estimateMessageStore } from '@/stores/feedbackStore'

const clipMessages = clipMessageStore()
const commonCheck = commonCheckStore()
const estimateMessages = estimateMessageStore()
const formaMentis = formaMentisStore()

onMounted(() => {
  if (formaMentis.mentis) {
    feedbackMessage.textContent = ''
    feedbackMessage.style.display = 'none'
    alertMessage.textContent = `Attention, a forma mentis is already set. Do you want to replace ${formaMentis.mentis.name.split('.')[0]}?`
    alertMessage.style.display = 'block'
  }
})

function clipFormaMentis() {
  const jsonFormaMentis = document.getElementById('jsonFormaMentis')
  if (jsonFormaMentis.files[0] != undefined) {
    formaMentis.mentis = jsonFormaMentis.files[0]
    alertMessage.textContent = ''
    alertMessage.style.display = 'none'
    const formaMentisName = formaMentis.mentis.name.split('.')[0]
    feedbackMessage.textContent = `You have now selected ${formaMentisName}.`
    feedbackMessage.style.display = 'block'
    clipMessages.resultMessage = `Selected: ${formaMentisName}`
    commonCheck.formaMentisIsSelected = true
    estimateMessages.alertMessage = ''
  }
  if (formaMentis.mentis) {
    console.log(formaMentis.mentis)
  }
}
</script>
