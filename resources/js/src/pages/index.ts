import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import WelcomePage from './Welcome/WelcomePage.vue'
import ProfilePage from '@/pages/Profile/ProfilePage.vue'
import HomePage from '@/pages/Home/HomePage.vue'

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        component: HomePage,
        children: [
            {
                path: '/profile/:username',
                component: ProfilePage
            }
        ]
    },
    {
        path: '/welcome',
        component: WelcomePage
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
