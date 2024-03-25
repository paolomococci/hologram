<template>
    <div class="watcher min-watcher">
        <p>
            Submit a query filtering data by <em>available</em> field:
            <input v-model.lazy="query" />
        </p>
    </div>
    <div v-if="!isValidStringFilter" class="alert-box">
        <strong v-if="!isValidStringFilter">{{ alertMessage }}</strong>
    </div>
    <div class="watcher">
        <p>{{ statusMessage }}
        </p>
    </div>
    <div class="watcher">
        <table>
            <caption>data retrieved</caption>
            <thead>
                <tr>
                    <th>available</th>
                    <th>image name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in filteredList" :key="item.id">
                    <td>{{ item.available }}</td>
                    <td>{{ item.imageName }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style>
p {
    padding: 1rem;
}

input {
    margin: 1rem;
    padding: 0.5rem;
    border-radius: 0.25rem;
}

.watcher {
    margin: 1rem;
}

.alert-box {
    color: #666;
    background-color: #ff0;
    border: 1px solid #a91;
    border-radius: 0.5rem;
    padding: 1rem;
}

strong {
    color: #e32;
}
</style>

<script setup>
import { computed, ref, watch } from 'vue'
import { API_TEST } from '../../env'

const query = ref('')
const dataRetrieved = ref()

const filteredList = computed(() => {
    let retrieved = dataRetrieved
    let filtered = []
    if (query.value.slice(0, -1) == 'available' || query.value.slice(0, -1) == 'unavailable') {
        for (const item in retrieved.value) {
            let data = retrieved.value[item]
            if (data.available == availabilityToggle(query.value.slice(0, -1))) {
                filtered.push(data)
            }
        }
        return filtered
    } else {
        return retrieved.value
    }
})

const statusMessage = ref("Don't forget the final '?' mark to submit the query and type enter.")
const alertMessage = ref("Valid string is 'available?' or 'unavailable?'. Otherwise no filter will apply.")
const isValidStringFilter = ref(true)

function queryValidate(q) {
    let queryParam = q.value
    queryParam = queryParam.substring(0, queryParam.length - 1)
    return (queryParam == 'available' || queryParam == 'unavailable')
}

function availabilityToggle(q) {
    return (q == 'available')
}

// watch on ref
// {"available": boolean, "imageName": string}
watch(query, async (newQuery, oldQuery) => {
    if (newQuery.indexOf('?') > -1) {
        statusMessage.value = 'Wait response for new query...'
        try {
            const res = await fetch(API_TEST)
            dataRetrieved.value = await res.json()
            statusMessage.value = 'Done!'
            isValidStringFilter.value = queryValidate(query)
        } catch (error) {
            statusMessage.value = 'Error! New query response from API not found. ' + error
        }
    } else if (oldQuery.indexOf('?') > -1) {
        statusMessage.value = 'Wait response for old query...'
        try {
            const res = await fetch(API_TEST)
            dataRetrieved.value = await res.json()
            statusMessage.value = 'Done!'
            isValidStringFilter.value = queryValidate(query)
        } catch (error) {
            statusMessage.value = 'Error! Old query response from API not found. ' + error
        }
    }
})
</script>