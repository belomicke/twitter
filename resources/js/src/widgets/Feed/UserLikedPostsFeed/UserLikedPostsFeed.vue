<script setup lang="ts">
import { useFeedStore } from '@/entities/Feed/store'
import PostFeed from '@/entities/Feed/ui/PostFeed.vue'
import UserLikedPostsEmptyFeed from './UserLikedPostsEmptyFeed.vue'

const props = defineProps({
    username: {
        type: String,
        required: true,
    },
})

const feedStore = useFeedStore()

function fetch() {
    feedStore.fetchUserLikedPostsFeed(props.username)
}
</script>

<template>
    <post-feed
        :id="`user:${username}:liked_posts`"
        window
        @fetch="fetch"
    >
        <user-liked-posts-empty-feed
            :username="username"
        />
    </post-feed>
</template>

<style scoped>

</style>
