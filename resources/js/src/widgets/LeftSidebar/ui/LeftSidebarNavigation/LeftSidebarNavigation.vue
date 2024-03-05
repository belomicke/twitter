<script setup lang="ts">
import { computed, PropType, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import PostCreatorModal from './ui/PostCreatorModal.vue'
import LeftSidebarNavigationItem from './ui/LeftSidebarNavigationItem.vue'
import IUser from '@/shared/api/types/models/User'
import { IconNames } from '@/shared/ui/XIcon'
import XButton from '@/shared/ui/XButton/XButton.vue'

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
        required: true,
    },
})

const creator = ref<InstanceType<typeof PostCreatorModal> | null>(null)

const router = useRouter()
const route = useRoute()

const links = computed((): ILink[] => {
    return [
        {
            id: 1,
            icon: 'home',
            text: 'Главная',
            active: route.path === '/',
            clickHandler: () => {
                router.push('/')
            },
        },
        {
            id: 2,
            icon: 'search',
            text: 'Поиск',
            active: route.path.startsWith(`/search`),
            clickHandler: () => {
                router.push(`/search`)
            },
        },
        {
            id: 3,
            icon: 'profile',
            text: 'Профиль',
            active: route.path.startsWith(`/profile/${user?.username}`),
            clickHandler: () => {
                router.push(`/profile/${user?.username}`)
            },
        },
    ]
})

function openPostCreator() {
    creator.value?.open()
}
</script>

<template>
    <div class="nav">
        <left-sidebar-navigation-item
            v-for="link in links"
            :key="link.id"
            :active="link.active"
            :icon="link.icon"
            :text="link.text"
            @click="link.clickHandler"
        />
        <x-button
            type="primary"
            size="extra-large"
            bold
            @click="openPostCreator"
        >
            Опубликовать пост
        </x-button>
    </div>
    <post-creator-modal
        ref="creator"
    />
</template>

<style scoped>
.nav {
    display: flex;
    flex-direction: column;
    grid-gap: 10px;
}
</style>
