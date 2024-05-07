<script setup lang="ts">

import PostFeed from '@/entities/Feed/ui/PostFeed.vue'
import BookmarkedPostsEmptyFeed from './BookmarkedPostsEmptyFeed.vue'
import { useFeedStore } from '@/entities/Feed/store'

const feedStore = useFeedStore()

function fetch() {
    feedStore.fetchBookmarkedPostsFeed()
}
</script>

<template>
    <post-feed
        id="bookmarked-posts"
        window
        @fetch="fetch"
    >
        <bookmarked-posts-empty-feed />
    </post-feed>
</template>

<style scoped>

</style>
