<script setup lang="ts">
import 'moment/locale/ru'

import { onMounted, PropType, ref } from 'vue'

import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import UserBanner from '@/entities/User/ui/UserBanner.vue'
import IUser from '@/shared/api/types/models/User'

import ProfileActions from './ui/ProfileActions/ProfileActions.vue'
import ProfileInfo from './ui/ProfileInfo.vue'
import ProfilePageHeader from './ui/ProfilePageHeader.vue'
import ProfileTabs from '@/pages/Profile/ProfileLayout/ui/ProfileTabs.vue'
import { useRouter } from 'vue-router'

const props = defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
})

const router = useRouter()

const prevRoute = ref<string>('')

onMounted(() => {
    const stateBack = router.options.history.state.back as string

    if (stateBack && !stateBack.startsWith(`/profile/${props.user.username}`)) {
        prevRoute.value = stateBack
    }
})

function goBack() {
    if (prevRoute.value) {
        router.push(prevRoute.value)
    }
}
</script>

<template>
    <profile-page-header
        :user="user"
        @back="goBack"
    />
    <user-banner
        :username="user.username"
    />
    <div class="wrapper">
        <div class="container">
            <div class="top-info">
                <div class="avatar-container">
                    <user-avatar
                        :username="user.username"
                        rounded
                    />
                </div>
                <profile-actions
                    :user="user"
                />
            </div>
            <div class="info">
                <profile-info
                    :user="user"
                />
            </div>
        </div>
        <profile-tabs />
    </div>
    <slot />
</template>

<style scoped>
.wrapper {
    border-bottom: 1px solid var(--x-border-color);
}

.container {
    width: 100%;
    position: relative;
    padding: 0 15px;
}

.top-info {
    display: flex;
    align-items: start;
    justify-content: space-between;
    width: 100%;
    height: 70px;
}

.avatar-container {
    border-radius: 50%;
    border: 4px solid rgb(0, 0, 0);
    transform: translateY(-66px);
}

.info {
    padding-bottom: 15px;
}
</style>
