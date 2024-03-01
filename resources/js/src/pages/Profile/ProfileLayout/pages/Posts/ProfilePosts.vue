<script setup lang="ts">

import UserPostsFeed from '@/widgets/Feed/UserPostsFeed/UserPostsFeed.vue'
import { PropType } from 'vue/dist/vue'
import IUser from '@/shared/api/types/models/User'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
})
</script>

<template>
    <user-posts-feed :username="user.username" />
</template>

<style scoped>

</style>
