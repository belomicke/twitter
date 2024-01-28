import { createApp } from 'vue'
import { VueQueryPlugin } from '@tanstack/vue-query'
import App from './app'
import router from './pages'

const app = createApp(App)

app.use(router)
app.use(VueQueryPlugin)

app.mount('#app')
