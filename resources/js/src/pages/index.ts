import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'

import AppLayout from '@/pages/AppLayout/AppLayout.vue'
import HomePage from '@/pages/Home/HomePage.vue'
import PostPage from '@/pages/Post/PostPage.vue'
import ProfilePosts from '@/pages/Profile/ProfileLayout/pages/Posts/ProfilePosts.vue'
import ProfilePage from '@/pages/Profile/ProfilePage.vue'

import WelcomePage from './Welcome/WelcomePage.vue'
import ProfileLikedPosts from '@/pages/Profile/ProfileLayout/pages/Posts/ProfileLikedPosts.vue'
import SearchPage from '@/pages/Search/SearchPage.vue'

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        component: AppLayout,
        children: [
            {
                path: '/',
                component: HomePage,
            },
            {
                path: '/profile/:username',
                component: ProfilePage,
                children: [
                    {
                        path: '',
                        component: ProfilePosts,
                    },
                    {
                        path: 'liked',
                        component: ProfileLikedPosts,
                    },
                ],
            },
            {
                path: '/post/:id',
                component: PostPage,
            },
            {
                path: '/search',
                component: SearchPage,
            },
        ],
    },
    {
        path: '/welcome',
        component: WelcomePage,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
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
