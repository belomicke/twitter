<script setup lang="ts">
import { PropType } from 'vue'
import 'moment/locale/ru'
import ProfilePageHeader from './ui/ProfilePageHeader.vue'
import ProfileBanner from './ui/ProfileBanner.vue'
import ProfileInfo from './ui/ProfileInfo.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import IUser from '@/shared/api/types/models/User'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})
</script>

<template>
    <profile-page-header
        :user="user"
    />
    <profile-banner
        :path="user.profile_banner"
    />
    <div class="container">
        <div class="top-info">
            <div class="avatar-container">
                <user-avatar
                    :path="user.profile_picture"
                    rounded
                />
            </div>
        </div>
        <profile-info
            :user="user"
        />
    </div>
</template>

<style scoped>
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
</style>
