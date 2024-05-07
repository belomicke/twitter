<script setup lang="ts">
import { computed, PropType, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import PostCreatorModal from './ui/PostCreatorModal.vue'
import LeftSidebarNavigationItem from './ui/LeftSidebarNavigationItem.vue'
import IUser from '@/shared/api/types/models/User'
import { IconNames } from '@/shared/ui/XIcon'
import XButton from '@/shared/ui/XButton/XButton.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

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
            }
        },
        {
            id: 2,
            icon: 'search',
            text: 'Поиск',
            active: route.path.startsWith(`/search`),
            clickHandler: () => {
                router.push(`/search`)
            }
        },
        {
            id: 3,
            icon: 'bookmark',
            text: 'Закладки',
            active: route.path === '/bookmark',
            clickHandler: () => {
                router.push('/bookmark')
            }
        },
        {
            id: 4,
            icon: 'profile',
            text: 'Профиль',
            active: route.path.startsWith(`/profile/${user?.username}`),
            clickHandler: () => {
                router.push(`/profile/${user?.username}`)
            }
        }
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
            class="button"
            size="extra-large"
            bold
            @click="openPostCreator"
        >
            <span class="text">Опубликовать пост</span>
            <span class="icon">
                <x-icon icon="feather" />
            </span>
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

.icon {
    display: none;
}

@media (max-width: 1280px) {
    .nav {
        align-items: end;
    }

    .button {
        width: 50px !important;
        padding: 12px !important;
        border-radius: 50%;
    }

    .icon {
        display: block;
    }

    .text {
        display: none;
    }
}
</style>
