<script setup lang="ts">
import PostFeed from '@/entities/Feed/ui/PostFeed.vue'

import { useFeedStore } from '../../entities/Feed/store'

const feedStore = useFeedStore()

function fetch() {
    feedStore.fetchMyFollowingsPostsFeed()
}
</script>

<template>
    <post-feed
        id="my-followings-posts"
        window
        @fetch="fetch"
    />
</template>
