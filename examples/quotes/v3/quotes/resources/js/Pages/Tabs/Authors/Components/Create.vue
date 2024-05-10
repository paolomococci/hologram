<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.name" size="30" type="text" name="name" id="name" placeholder="Name"
                    required minlength="1" maxlength="255" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.surname" size="30" type="text" name="surname" id="surname"
                    placeholder="Surname" required minlength="1" maxlength="255" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.nickname" size="30" type="text" name="nickname" id="nickname"
                    placeholder="Nickname" maxlength="255" />
            </div>
            <div>
                <input
                    class="left-4 m-2 text-xs rounded-md border border-purple-300 caret-purple-700 focus:border-2 focus:border-purple-500 text-slate-600"
                    v-model.lazy="createForm.email" size="30" name="email" id="email" placeholder="Email" required
                    minlength="8" maxlength="255" />
            </div>
            <div>
                <button
                    class="p-1 px-2 mx-2 text-sm text-purple-900 bg-purple-200 rounded-md hover:bg-purple-300 hover:shadow-md active:text-purple-600 active:shadow-sm"
                    type="submit" :disabled="createForm.processing">Save</button>
                <button
                    class="p-1 px-2 mx-2 text-sm rounded-md text-slate-900 bg-slate-200 hover:bg-slate-300 hover:shadow-md active:text-slate-600 active:shadow-sm"
                    type="reset">Reset</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, defineEmits } from 'vue'
import { router } from "@inertiajs/vue3"

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

const createForm = reactive({
    name: null,
    surname: null,
    nickname: null,
    email: null,
})

/** if there are no errors it sends the values and clears the fields */
function submit() {
    let author = JSON.parse(
        JSON.stringify(createForm)
    )
    // console.log(author.email)
    author.name = checkAllowedCharacters(author.name)
    author.surname = checkAllowedCharacters(author.surname)
    author.nickname = checkAllowedCharacters(author?.nickname)
    const proxy = new Proxy(author, {})
    // console.log(proxy)
    // console.log(createForm)
    // console.log(isValidEmail(author.email))

    if (isValidEmail(author.email)) {
        router.post("/authors", author)
        postMessage()
        if (fieldEmptyCheck()) {
            createForm.name = ''
            createForm.surname = ''
            createForm.nickname = ''
            createForm.email = ''
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
</script>

<style scoped>
/* TODO */
</style>
