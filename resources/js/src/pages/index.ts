import { createRouter, createWebHistory } from 'vue-router'
import WelcomePage from './Welcome/WelcomePage.vue'
import ProfilePage from '@/pages/Profile/ProfilePage.vue'
import HomePage from '@/pages/Home/HomePage.vue'

const routes = [
    {
        path: '/',
        component: HomePage
    },
    {
        path: '/welcome',
        component: WelcomePage
    },
    {
        path: '/profile/:username',
        component: ProfilePage
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to) => {
    const token = localStorage.getItem('token')

    if (!token && to.path !== '/welcome') {
        return '/welcome'
    } else if (token && to.path === '/welcome') {
        return '/'
    }

    return true
})

export default router
