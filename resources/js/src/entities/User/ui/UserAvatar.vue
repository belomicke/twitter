<script setup lang="ts">
import { useUserStore } from '@/entities/User/store'
import { computed } from 'vue'

const { size, username } = defineProps({
    username: {
        type: String,
        required: true,
    },
    size: {
        type: Number,
        required: false,
        default: 128,
    },
    rounded: {
        type: Boolean,
        required: false,
        default: false,
    },
})

const userStore = useUserStore()
const user = computed(() => {
    return userStore.getUserByUsername(username)
})

const path = computed(() => {
    if (!user.value) return ''

    if (size <= 128) {
        return user.value.profile_picture.small
    } else if (size <= 200) {
        return user.value.profile_picture.default
    } else {
        return user.value.profile_picture.large
    }
})
</script>

<template>
    <div
        class="user-avatar"
        :class="{
            'rounded': rounded,
        }"
        :style="{
            'background-image': `url(${path})`,
            'width': `${size}px`,
            'height': `${size}px`
        }"
    />
</template>

<style scoped>
.user-avatar {
    background-size: cover;
    background-position: center center;
}

.user-avatar.rounded {
    border-radius: 50%;
}
</style>
