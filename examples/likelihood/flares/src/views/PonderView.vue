<template>
  <div class="right-view">
    <section>
      <h1 class="headingOne">Ponder</h1>
      <h3 class="headingThree">now it's time to weigh the data</h3>
      <p>
        This is the most expensive step in terms of computational time.
      </p>
      <p>
        Computation that will still remain local, since the application runs on the browser.
      </p>
      <p>
        Please click on the following button if you want to start evaluating the previously uploaded data.
      </p>
      <p>
        Thank you.
      </p>
      <form class="flaresForm" @submit.prevent="onSubmit" id="ponderDataForm" name="ponderDataForm">
        <input @click="ponderDataField()" id="ponderSubmit" name="ponderSubmit" type="submit" value="PONDER">
        <span class="resultMessage" id="resultMessageElement" v-text="ponderMessages.resultMessage"></span>
        <span class="errorMessage" id="errorMessageElement" v-text="ponderMessages.errorMessage"></span>
        <a class="downloadLink" title="download mentis in JSON format" id="downloadNeuralNet"
          name="downloadNeuralNet"><i class="landing-icon pi pi-arrow-down"></i></a>
      </form>
    </section>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { trainingAndSaveMentis } from '@/lib/mentis'
import { timeSpentOn } from '@/lib/utils'
import { tuplesDataStore } from '@/stores/tuplesStore'
import { commonCheckStore, ponderMessageStore } from '@/stores/feedbackStore'
import { blobJsonNeuralNetStore } from '@/stores/mentisStore'

const ponderMessages = ponderMessageStore()
const commonCheck = commonCheckStore()
const tuplesData = tuplesDataStore()
const blobJsonNeuralNet = blobJsonNeuralNetStore()
const formaMentisRef = ref('')

onMounted(() => {
  if (blobJsonNeuralNet.blob) {
    downloadNeuralNet.setAttribute('href', URL.createObjectURL(blobJsonNeuralNet.blob))
    downloadNeuralNet.setAttribute('download', blobJsonNeuralNet.name)
    downloadNeuralNet.style.display = 'block'
  }
  if (!commonCheck.dataFileIsSelected) {
    ponderSubmit.style.pointerEvents = 'none'
    ponderMessages.resultMessage = 'Please first select a valid data file in the previous step, thanks.'
  } else {
    ponderMessages.resultMessage = 'Well, now the training can start on the newly selected data. Thanks.'
  }
})

function ponderDataField() {
  try {
    const beginTime = performance.now()
    downloadNeuralNet.style.display = 'none'
    console.log(`Started training on data field: ${tuplesData.name}...`)
    // TODO: It is necessary to insert some feedback that indicates that the system is training on the data!
    // ponderMessages.resultMessage = 'Please wait for the end of the training process!'
    // ponderMessages.inProcess = 'display: block;'
    formaMentisRef.value = JSON.stringify(trainingAndSaveMentis(tuplesData.tuples))
    const endTime = performance.now()
    const timeElapsed = timeSpentOn(beginTime, endTime)
    console.log(`Got a new forma mentis: ${typeof (formaMentisRef.value)} in ${timeElapsed}.`)
    blobJsonNeuralNet.blob = new Blob(
      [formaMentisRef.value], {
      type: "application/json"
    })
    blobJsonNeuralNet.name = `${tuplesData.name}_JsonNeuralNet.json`
    downloadNeuralNet.setAttribute('href', URL.createObjectURL(blobJsonNeuralNet.blob))
    downloadNeuralNet.setAttribute('download', blobJsonNeuralNet.name)
    downloadNeuralNet.style.display = 'block'
    ponderMessages.inProcess = 'display: none;'
    ponderMessages.resultMessage = `Now, after ${timeElapsed}, it is possible to download the result in JSON format, thank you.`
    console.log(`Now, after ${timeElapsed}, it is possible to download the result in JSON format, thank you.`)
  } catch (error) {
    ponderMessages.inProcess = 'display: none;'
    ponderMessages.errorMessage = 'Sorry, unfortunately there was an error during the training phase!'
    console.error(error)
  }
}
</script>
