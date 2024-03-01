<script setup lang="ts">
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import UserFollowButton from '@/features/user/FollowButton/UserFollowButton.vue'
import { useUserStore } from '@/entities/User/store'

const { username } = defineProps({
    username: {
        type: String,
        required: true,
    },
})

const userStore = useUserStore()
const { getUserByUsername } = storeToRefs(userStore)

const user = computed(() => {
    return getUserByUsername.value(username)
})
</script>

<template>
    <user-follow-button
        v-if="user"
        :username="username"
    />
</template>

<style scoped>
</style>
