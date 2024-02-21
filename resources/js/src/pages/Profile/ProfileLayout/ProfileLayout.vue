<script setup lang="ts">
import 'moment/locale/ru'

import { PropType } from 'vue'

import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import UserBanner from '@/entities/User/ui/UserBanner.vue'
import IUser from '@/shared/api/types/models/User'

import ProfileActions from './ui/ProfileActions/ProfileActions.vue'
import ProfileInfo from './ui/ProfileInfo.vue'
import ProfilePageHeader from './ui/ProfilePageHeader.vue'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
})
</script>

<template>
    <profile-page-header
        :user="user"
    />
    <user-banner
        :username="user.username"
    />
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
    <slot />
</template>

<style scoped>
.container {
    width: 100%;
    position: relative;
    padding: 0 15px;
    border-bottom: 1px solid var(--x-border-color);
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
