import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { VueQueryPlugin } from '@tanstack/vue-query'
import App from './app'
import router from './pages'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
import { ObserveVisibility } from '@uxieverity/vue3-observe-visibility'

const app = createApp(App)
const pinia = createPinia()

app.use(router)
app.use(pinia)
app.use(VueQueryPlugin)
app.directive('observe-visibility', ObserveVisibility)

app.mount('#app')
