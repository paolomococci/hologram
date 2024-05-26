<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.name" size="30" type="text" name="name" id="name" placeholder="Name"
                    required minlength="1" maxlength="255"
                    @blur="setStoredName()" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.surname" size="30" type="text" name="surname" id="surname"
                    placeholder="Surname" required minlength="1" maxlength="255"
                    @blur="setStoredSurname()" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.nickname" size="30" type="text" name="nickname" id="nickname"
                    placeholder="Nickname" maxlength="255"
                    @blur="setStoredNickname()" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.email" size="30" name="email" id="email" placeholder="Email" required
                    minlength="8" maxlength="255"
                    @blur="setStoredEmail()" />
            </div>
            <div>
                <progress class="mb-4 w-full h-1 bg-purple-400 rounded-lg dark:bg-purple-600" v-if="createForm.progress"
                    :value="createForm.progress.percentage" max="100">
                    {{ createForm.progress.percentage }}%
                </progress>
            </div>
            <div>
                <button
                    class="p-1 px-2 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm"
                    type="submit" :disabled="createForm.processing">Save</button>
                <button
                    class="p-1 px-2 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm"
                    type="reset" @click="clearStoredData()">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { defineEmits } from 'vue'
import { router, useForm } from '@inertiajs/vue3'
import { authorStore } from '@/store'

const emit = defineEmits(['postFeedbackMessage'])

/** transmits it back to the parent component */
function postMessage() {
    if (fieldEmptyCheck()) {
        console.log('You have just registered a new author with the following name: ' + createForm.name + ' ' + createForm.surname)
        emit('postFeedbackMessage', `You have just registered a new author with the following name: ${createForm.name} ${createForm.surname}`)
    } else {
        console.log('Attention, the form has not been filled out correctly!')
        emit('postFeedbackMessage', 'Attention, the form has not been filled out correctly!')
    }
}

const createForm = useForm({
    name: authorStore.name,
    surname: authorStore.surname,
    nickname: authorStore.nickname,
    email: authorStore.email,
})

/** if there are no errors it sends the values and clears the fields */
function submit() {
    let author = JSON.parse(
        JSON.stringify(createForm)
    )
    author.name = checkAllowedCharacters(author.name)
    author.surname = checkAllowedCharacters(author.surname)
    author.nickname = checkAllowedCharacters(author?.nickname)

    if (isValidEmail(author.email)) {
        router.post("/authors", author)
        postMessage()
        if (fieldEmptyCheck()) {
            clearAllFieldsAndStoredData()
        }
    } else {
        createForm.email = ''
        postMessage()
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
    let checkField = (createForm.name.length > 1 && createForm.surname.length > 1 && createForm.email.length > 8) &&
        (createForm.name != null && createForm.surname != null && createForm.email != null)
    return checkField
}

/** retains the value of name even if you change tabs */
function setStoredName() {
    authorStore.name = createForm.name
}

/** retains the value of surname even if you change tabs */
function setStoredSurname() {
    authorStore.surname = createForm.surname
}

/** retains the value of nickname even if you change tabs */
function setStoredNickname() {
    authorStore.nickname = createForm.nickname
}

/** retains the value of email even if you change tabs */
function setStoredEmail() {
    authorStore.email = createForm.email
}

/** delete explicitly the field values from the store */
function clearStoredData() {
    authorStore.name = ''
    authorStore.surname = ''
    authorStore.nickname = ''
    authorStore.email = ''
}

/** clears the form fields and the stored data */
function clearAllFieldsAndStoredData() {
    createForm.name = ''
    authorStore.name = ''
    createForm.surname = ''
    authorStore.surname = ''
    createForm.nickname = ''
    authorStore.nickname = ''
    createForm.email = ''
    authorStore.email = ''
}
</script>

<style scoped>
/* TODO */
</style>
