import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'

import { AppLayout } from './AppLayout'
import { HomePage } from './Home'
import { WelcomePage } from './Welcome'
import { BookmarkPage } from '@/pages/Bookmark'
import { SearchPage } from '@/pages/Search'
import { PostPage } from '@/pages/Post'
import { ProfileLikedPosts, ProfilePage, ProfilePosts } from '@/pages/Profile'

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        component: AppLayout,
        children: [
            {
                path: '/',
                component: HomePage
            },
            {
                path: '/profile/:username',
                component: ProfilePage,
                children: [
                    {
                        path: '',
                        component: ProfilePosts
                    },
                    {
                        path: 'liked',
                        component: ProfileLikedPosts
                    }
                ]
            },
            {
                path: '/post/:id',
                component: PostPage
            },
            {
                path: '/search',
                component: SearchPage
            },
            {
                path: '/bookmark',
                component: BookmarkPage
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
    routes,
    scrollBehavior: (to, from, savedPosition) => {
        if (savedPosition) {
            return savedPosition
        } else {
            return { top: 0 }
        }
    }
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
