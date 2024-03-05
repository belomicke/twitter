<script setup lang="ts">
import PostFeed from '@/entities/Feed/ui/PostFeed.vue'

import { useFeedStore } from '@/entities/Feed/store'
import UserPostsEmptyFeed from '@/widgets/Feed/UserPostsFeed/UserPostsEmptyFeed.vue'

const props = defineProps({
    username: {
        type: String,
        required: true,
    },
})

const feedStore = useFeedStore()

function fetch() {
    feedStore.fetchUserPostsFeed(props.username)
}
</script>

<template>
    <post-feed
        :id="`user:${username}:posts`"
        window
        @fetch="fetch"
    >
        <user-posts-empty-feed
            :username="username"
        />
    </post-feed>
</template>
