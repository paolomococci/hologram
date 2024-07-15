<template>
  <div class="right-view">
    <section>
      <h1 class="headingOne">Estimate</h1>
      <h3 class="headingThree">get an esteem</h3>
      <p>
        Please enter the latest data obtained from the measurement tools and start the calculation of the estimate of
        what future results could be.
      </p>
      <p>
        Thank you.
      </p>
      <form class="flaresForm" @submit.prevent="onSubmit" id="esteemFromLatestData" name="esteemFromLatestData"
        enctype="multipart/form-data">
        <label class="labelNumber" for="apparentWidth">apparent width (range: from {{ MIN_COORDINATES_VALUE }} to {{
          MAX_COORDINATES_VALUE }})</label>
        <input class="inputNumber" type="number" :min="MIN_COORDINATES_VALUE" :max="MAX_COORDINATES_VALUE" value="0.00"
          step="0.01" name="apparentWidth" id="apparentWidth">
        <label for="apparentHeight">apparent height (range: from {{ MIN_COORDINATES_VALUE }} to {{ MAX_COORDINATES_VALUE
          }})</label>
        <input type="number" :min="MIN_COORDINATES_VALUE" :max="MAX_COORDINATES_VALUE" value="0.00" step="0.01"
          name="apparentHeight" id="apparentHeight">
        <label for="apparentDepth">apparent depth (range: from {{ MIN_COORDINATES_VALUE }} to {{ MAX_COORDINATES_VALUE
          }})</label>
        <input type="number" :min="MIN_COORDINATES_VALUE" :max="MAX_COORDINATES_VALUE" value="0.00" step="0.01"
          name="apparentDepth" id="apparentDepth">
        <label for="virtualTime">virtual time (range: from {{ MIN_COORDINATES_VALUE }} to {{ MAX_COORDINATES_VALUE
          }})</label>
        <input type="number" :min="MIN_COORDINATES_VALUE" :max="MAX_COORDINATES_VALUE" value="0.00" step="0.01"
          name="virtualTime" id="virtualTime">
        <label for="foldingTime">folding time (range: from {{ MIN_COORDINATES_VALUE }} to {{ MAX_COORDINATES_VALUE
          }})</label>
        <input type="number" :min="MIN_COORDINATES_VALUE" :max="MAX_COORDINATES_VALUE" value="0.00" step="0.01"
          name="foldingTime" id="foldingTime">
        <input class="submitForm" @click="esteemFromLatestData()" id="estimateSubmit" name="estimateSubmit" type="submit" value="ESTEEM">
        <input type="reset" value="RESET">
        <p class="resultMessage" v-text="estimateMessages.resultMessage"></p>
        <p class="alertMessage" v-text="estimateMessages.alertMessage"></p>
        <p class="errorMessage" v-text="estimateMessages.errorMessage"></p>
      </form>
    </section>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { MIN_COORDINATES_VALUE, MAX_COORDINATES_VALUE } from '../../env'
import { resumeMentis, makeEsteem } from '@/lib/mentis'
import { formaMentisStore } from '@/stores/mentisStore'
import { commonCheckStore, estimateMessageStore } from '@/stores/feedbackStore'

const estimateMessages = estimateMessageStore()
const commonCheck = commonCheckStore()
const formaMentis = formaMentisStore()

onMounted(() => {
  if (!commonCheck.formaMentisIsSelected) {
    estimateSubmit.style.pointerEvents = 'none'
    estimateMessages.alertMessage = 'Please first select a valid forma mentis in the previous step, thanks.'
  } else {
    estimateMessages.alertMessage = 'Well, now the estimate can be done with the forma mentis selected. Thanks.'
  }
})

function esteemFromLatestData() {
  const apparentWidth = document.getElementById('apparentWidth').value
  const apparentHeight = document.getElementById('apparentHeight').value
  const apparentDepth = document.getElementById('apparentDepth').value
  const virtualTime = document.getElementById('virtualTime').value
  const foldingTime = document.getElementById('foldingTime').value
  const isSet = (formaMentis.mentis) ? 'is correctly set' : 'is not set'
  console.log(`Estimate view, formaMentis.mentis ${isSet}`)
  if (formaMentis.mentis) {
    console.log(`Estimate view forma mentis from storage: ${formaMentis.mentis}`)
    const fileReader = new FileReader()
    fileReader.onload = (e) => {
      const jsonMentis = e.target.result
      const resumedMentis = resumeMentis(jsonMentis)
      const coordinates = []
      if (
        checkNumber(apparentWidth) &&
        checkNumber(apparentHeight) &&
        checkNumber(apparentDepth) &&
        checkNumber(virtualTime) &&
        checkNumber(foldingTime)
      ) {
        coordinates.push(apparentWidth)
        coordinates.push(apparentHeight)
        coordinates.push(apparentDepth)
        coordinates.push(virtualTime)
        coordinates.push(foldingTime)
        const esteem = makeEsteem(resumedMentis, coordinates)
        const esteemFloat = []
        for (let index = 0; index < esteem[0].length; index++) {
          esteemFloat.push(esteem[0][index].toFixed(2))
        }
        estimateMessages.alertMessage = ''
        const esteemString = esteemFloat.toString()
        estimateMessages.resultMessage = esteemString.replace(/,/gi, ' ')
      } else {
        console.log('Invalid coordinates!')
        estimateMessages.errorMessage = 'Invalid coordinates!'
      }
    }
    fileReader.readAsText(formaMentis.mentis)
  } else {
    console.log('Invalid forma mentis!')
    estimateMessages.errorMessage = 'Invalid forma mentis!'
  }
}

function checkNumber(n) {
  let toCheck = Math.floor(n)
  toCheck = toCheck.toFixed(2)
  return (toCheck >= MIN_COORDINATES_VALUE && toCheck <= MAX_COORDINATES_VALUE)
}
</script>
