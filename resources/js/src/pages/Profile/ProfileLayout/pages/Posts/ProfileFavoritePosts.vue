<script setup lang="ts">
import { PropType } from "vue"
import IUser from "@/shared/api/types/models/User"
import UserFavoritePostsFeed from "@/widgets/Feed/UserFavoritedPostsFeed/UserFavoritePostsFeed.vue"

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})
</script>

<template>
    <user-favorite-posts-feed :username="user.username" />
</template>

<style scoped>

</style>
