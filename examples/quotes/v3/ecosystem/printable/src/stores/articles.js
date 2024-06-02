import { defineStore } from 'pinia'
import axios from 'axios'
import { ARTICLES_API, API_TOKEN, BASE } from '../../env'

/** query the articles api */

const query = axios.create({
    baseURL: BASE,
    timeout: 2000,
    headers: { 'Authorization': `Bearer ${API_TOKEN}` }
})

export const articleStore = defineStore(
    'index', () => {
        let promise = getPromiseTwo(ARTICLES_API)

        return { promise }
    })

function getPromiseTwo(url) {
    let promise = new Promise(
        function (resolve, reject) {
            resolve(query.get(url))
            reject(new Error('API not reachable!'))
        }
    )
    return promise
}
