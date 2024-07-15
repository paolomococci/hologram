<template>
  <div class="right-view">
    <section>
      <h1 class="headingOne">Upload</h1>
      <h3 class="headingThree">please select the data file</h3>
      <p>
        The data contained in the chosen file must present on each line the five coordinates of the five-dimensional
        field separated by commas, first the three spatial coordinates, then the apparent time coordinate and finally
        the horizontal time coordinate.
      </p>
      <p>
        Thank you.
      </p>
      <form class="flaresForm" @submit.prevent="onSubmit" id="uploadDataFile" name="uploadDataFile"
        enctype="multipart/form-data">
        <label for="dataField">Choose a CSV five-dimensional data</label>
        <input type="file" id="dataField" name="dataField" accept="text/csv">
        <input class="submitForm" @click="uploadDataField()" type="submit" value="UPLOAD">
        <input type="reset" value="RESET">
        <span class="resultMessage" v-text="uploadMessages.resultMessage"></span>
        <div v-if="uploadMessages.rangeErrorMessage.length > 0">
          <span class="errorMessage" v-text="uploadMessages.rangeErrorMessage"></span>
        </div>
        <span class="errorMessage" v-text="uploadMessages.errorMessage"></span>
      </form>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { MIN_COORDINATES_VALUE, MAX_COORDINATES_VALUE } from '../../env'
import { tuplesDataStore } from '@/stores/tuplesStore'
import { commonCheckStore, ponderMessageStore, uploadMessageStore } from '@/stores/feedbackStore'

const uploadMessages = uploadMessageStore()
const commonCheck = commonCheckStore()
const ponderMessages = ponderMessageStore()
const tuplesData = tuplesDataStore()
const tuples = ref('')

/** upload data field and prepare forma mentis to download in JSON format */
function uploadDataField() {
  let tuplesName = ''
  if (dataField.files[0] != undefined) {
    const dataFile = dataField.files[0]
    tuplesName = dataFile.name.split('.')[0]
    console.log(`Data file name: ${dataFile.name}`)
    const fileReader = new FileReader()
    fileReader.onload = (event) => {
      // ref tuples
      tuples.value = parseCsvDataField(event.target.result)
      // to check that the values ​​fall within a certain range
      if (toCheckWithinRange(tuples.value)) {
        // here's what to do if the range of tuple values ​​is correct
        console.log(`Data field name is: ${tuplesName}`)
        uploadMessages.resultMessage = `Data field name is: ${tuplesName}`
        tuplesData.name = tuplesName
        console.log(`Values of tuples: ${tuples.value}`)
        tuplesData.tuples = tuples.value
        tuplesData.trainingDataField = prepareTrainingDataFieldObject(tuples.value)
        // console.log(`Training data field object: ${tuplesData.trainingDataField}`)
        commonCheck.dataFileIsSelected = true
        ponderMessages.resultMessage = ''
      } else {
        uploadMessages.errorMessage = `Warning, at least one value out of range has been detected on tuples named: ${tuplesName}!`
        console.error(`Warning, at least one value out of range has been detected on tuples named: ${tuplesName}!`)
      }
    }
    fileReader.readAsText(dataFile)
  } else {
    uploadMessages.errorMessage = 'Warning, no valid file selected!'
    console.error('Warning, no valid file selected!')
  }
}

/** parses the rows in the CSV data file and returns an array of tuples */
function parseCsvDataField(csvDataField) {
  const tuples = []
  const csvDataObject = csvDataField.split(/\n/)
  const csvDataArray = Object.keys(csvDataObject).map(
    (key) => [csvDataObject[key]]
  )
  csvDataArray.forEach(element => {
    let coordinates = element[0].split(/,/)
    if (coordinates.length == 5) {
      let tuple = Object.keys(coordinates).map(
        (key) => [parseInt(coordinates[key])]
      )
      tuples.push(tuple.flat())
    }
  })

  return tuples
}

/** prepares the data for the next training by collecting it and returning it into an array of object */
function prepareTrainingDataFieldObject(tuples) {
  const trainingDataField = []
  for (let id = 1, index = 0; index < tuples.length; id++, index++) {
    const tuple = tuples[index];
    trainingDataField.push({
      'id': id,
      'input': tuple,
      'output': tuples[id]
    })
  }

  return trainingDataField
}

/** check that the values ​​fall within a certain range */
function toCheckWithinRange(tuples) {
  let checkResult = true
  let value = 0
  let row = 1
  tuples.forEach(tuple => {
    let column = 1
    tuple.forEach(elementValue => {
      value = parseInt(elementValue)
      if (value < MIN_COORDINATES_VALUE || value > MAX_COORDINATES_VALUE || Number.isNaN(value)) {
        console.log(`An invalid value was detected in row ${row} and column ${column}.`)
        uploadMessages.rangeErrorMessage.push(`An invalid value was detected in row ${row} and column ${column}`)
        checkResult = false
      }
      column++
    })
    row++
  })
  return checkResult
}
</script>
