<script setup lang="ts">
import { computed } from 'vue'
import { useUserStore } from '@/entities/User/store'

const { size, username } = defineProps({
    username: {
        type: String,
        required: true,
    },
    size: {
        type: Number,
        required: false,
        default: 200,
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

    if (size <= 200) {
        return user.value.profile_banner.default
    } else if (size > 200) {
        return user.value.profile_banner.large
    }
})
</script>

<template>
    <div
        class="banner"
        :style="{
            'background-image': `url(${path})`,
            'height': `${size}px`
        }"
    >
        <slot></slot>
    </div>
</template>

<style scoped>
.banner {
    position: relative;
    background-size: cover;
    background-position: center center;
    background-color: rgb(50, 50, 50);
}
</style>
