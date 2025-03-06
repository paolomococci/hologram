<script setup>
import { ref } from 'vue'
import axios from 'axios'
import ENV from '../env'
import { Loader } from 'lucide-vue-next'

const pingResult = ref('')

const BASE_URL = ENV.baseUrl

axios.create({
    httpsAgent: {
        rejectUnauthorized: false,
        secureOptions: 0x2 | 0x4,
    },
})
axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true
axios.defaults.baseURL = BASE_URL

async function retrieve(uri) {
    await axios.get("sanctum/csrf-cookie").then(response => {
        console.log(response.data)
    }).catch(error => {
        console.error(error)
    })
    await axios.get(uri).then(response => {
        console.log(response.data)
        pingResult.value = response.data.message
    }).catch(error => {
        console.error(error)
    })
}

retrieve("api/ping")
</script>

<template>
    <div v-if="!pingResult">
        <h5 class="flex items-center">
            <Loader class="ml-8 text-center w-20 h-20 stroke-1 stroke-orange-400 animate-[spin_1s_ease-in-out_infinite]" />
        </h5>
    </div>
    <div v-if="pingResult" class="items-center py-4">
        <h5 class="text-xl text-center text-slate-400">{{ pingResult }}</h5>
    </div>
</template>
