<template>
    <div>

        <form @submit.prevent="submit">
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.id" size="30" type="text" name="id" id="id" placeholder="#" readonly />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.name" size="30" type="text" name="name" id="name" placeholder="Name" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.surname" size="30" type="text" name="surname" id="surname"
                    placeholder="Surname" required minlength="16" maxlength="255" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.nickname" size="30" type="text" name="nickname" id="nickname"
                    placeholder="Nickname" maxlength="255" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="editForm.email" size="30" name="email" id="email" placeholder="Email" readonly
                    minlength="8" maxlength="255" />
            </div>
            <div class="pb-4">
                <label class="left-4 text-gray-900 text-md-center ms-3 dark:text-white"
                    for="suspended">suspended</label>
                <input class="left-4 ml-2 text-xs rounded-md border indeterminate:bg-gray-300 checked:bg-purple-700"
                    type="checkbox" v-model.lazy="editForm.suspended" name="suspended" id="suspended">
            </div>
            <div v-if="hasContributed()" class="pb-4">
                <p class="left-4 text-xs text-gray-900 ms-3 dark:text-white">
                    Contributed to the following articles:
                </p>
                <div class="text-xl font-semibold text-gray-900 ms-3 dark:text-white">
                    <ul>
                        <li class="left-4 text-xs text-gray-900 ms-3 dark:text-slate-200"
                            v-for="article in editForm?.articles" :key="article.id">
                            {{ article.title }}
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <button
                    class="px-2 py-1 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm"
                    type="submit" :disabled="editForm.processing">Save</button>
                <button
                    class="px-2 py-1 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm"
                    type="reset">Reset</button>
            </div>
        </form>

    </div>
</template>

<script setup>
import { reactive, onBeforeMount } from 'vue'
import { router } from "@inertiajs/vue3"
import axios from "axios"

const props = defineProps({
    itemId: String
})

const emit = defineEmits(['postFeedbackMessage'])

onBeforeMount(() => {
    fetchDataItem(props?.itemId)
})

/** transmits it back to the parent component */
function postMessage() {
    if (fieldEmptyCheck()) {
        console.log('You have just updated the ' + editForm.name + ' ' + editForm.surname + '\'s data!')
        emit('postFeedbackMessage', `You have just updated the ${editForm.name} ${editForm.surname}'s data!`)
    } else {
        console.log('Attention, the form has not been filled out correctly!')
        emit('postFeedbackMessage', 'Attention, the form has not been filled out correctly!')
    }
}

const editForm = reactive({
    id: null,
    name: null,
    surname: null,
    nickname: null,
    email: null,
    suspended: false,
    articles: [],
})

/** sends the values and clears the fields */
function submit() {
    let author = JSON.parse(
        JSON.stringify(editForm)
    )
    author.name = checkAllowedCharacters(author.name)
    author.surname = checkAllowedCharacters(author.surname)
    author.nickname = checkAllowedCharacters(author?.nickname)

    if (isValidEmail(author.email)) {
        if (fieldEmptyCheck()) {
            router.put("/authors", editForm)
            postMessage()
            editForm.id = '#'
            editForm.name = ''
            editForm.surname = ''
            editForm.nickname = ''
            editForm.email = ''
            editForm.suspended = false
        }
        // else {
        //     console.log(editForm)
        //     alert("Attention please: the name, surname and email fields are mandatory!")
        //     fetchDataItem(editForm.id)
        // }
    } else {
        editForm.email = ''
        postMessage()
    }
}

/** fetch data of item thanks to the id */
async function fetchDataItem(id) {
    if (id > 0) {
        try {
            const res = await axios.get("/authors/show/" + id)
            if (res.status) {
                console.log(res.data)
                editForm.id = res.data.id
                editForm.name = res.data.name
                editForm.surname = res.data.surname
                editForm.nickname = res.data?.nickname
                editForm.email = res.data.email
                editForm.suspended = res.data.suspended ? true : false
                editForm.articles = res.data?.articles
            }
        } catch (error) {
            console.log(error)
        }
    }
}

/** check that only allowed characters are passed */
function checkAllowedCharacters(str) {
    if (str === null) return ''
    str.trim()
    let allowedCharacters = /[^\w\s]/gi
    return str ? str.replace(allowedCharacters, '') : ''
}

/** check the validity of the email format */
function isValidEmail(email) {
    email.trim()
    const prefixRegex = /^([a-zA-Z0-9._-]+)$/
    const postfixRegex = /^([a-zA-Z0-9]+).([a-z]+).([a-z]+)?$/
    let splitted = email.split('@')
    if (splitted.length != 2) return false
    return (prefixRegex.test(splitted[0]) && postfixRegex.test(splitted[1]))
}

/** check if the mandatory fields have been filled in */
function fieldEmptyCheck() {
    let checkField = (editForm.name.length > 1 && editForm.surname.length > 1 && editForm.email.length > 8) &&
        (editForm.name != null && editForm.surname != null && editForm.email != null)
    return checkField
}

/** checks if an author has contributed to articles */
function hasContributed() {
    if (editForm?.articles.length > 0) {
        return true
    }
    return false;
}
</script>

<style scoped>
/* TODO */
</style>
