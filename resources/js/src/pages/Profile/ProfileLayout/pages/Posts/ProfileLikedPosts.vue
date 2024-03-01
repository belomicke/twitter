<script setup lang="ts">

import UserLikedPostsFeed from '@/widgets/Feed/UserLikedPostsFeed/UserLikedPostsFeed.vue'
import { PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'


defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
})
</script>

<template>
    <user-liked-posts-feed :username="user.username" />
</template>

<style scoped>

</style>
