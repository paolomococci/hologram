import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

// Imports dedicated to primevue components
import PrimeVue from 'primevue/config'
import Button from 'primevue/button'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

// Configuration of primevue and list of components used in this application
app.use(PrimeVue, {
    // this is where the options would go
    unstyled: true
})
app.component('Button', Button)

app.mount('#app')
