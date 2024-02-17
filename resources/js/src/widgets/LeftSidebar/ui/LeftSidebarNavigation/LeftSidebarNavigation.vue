<script setup lang="ts">
import { computed, PropType } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import LeftSidebarNavigationItem from './ui/LeftSidebarNavigationItem.vue'
import IUser from '@/shared/api/types/models/User'
import { IconNames } from '@/shared/ui/XIcon'

interface ILink {
    id: number
    icon: IconNames
    text: string
    active: boolean
    clickHandler: () => void
}

const { user } = defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})

const router = useRouter()
const route = useRoute()

const links = computed((): ILink[] => {
    return [
        {
            id: 1,
            icon: 'home',
            text: 'Главная',
            active: route.fullPath === '/',
            clickHandler: () => {
                router.push('/')
            }
        },
        {
            id: 2,
            icon: 'profile',
            text: 'Профиль',
            active: route.fullPath === `/profile/${user?.username}`,
            clickHandler: () => {
                router.push(`/profile/${user?.username}`)
            }
        }
    ]
})
</script>

<template>
    <div class="nav">
        <left-sidebar-navigation-item
            :active="link.active"
            :icon="link.icon"
            :text="link.text"
            @click="link.clickHandler"
            v-for="link in links"
            :key="link.id"
        />
    </div>
</template>

<style scoped>
.nav {
    display: flex;
    flex-direction: column;
    grid-gap: 10px;
}
</style>
