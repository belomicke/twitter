<script setup lang="ts">

import PostFeed from '@/entities/Feed/ui/PostFeed.vue'
import { useFeedStore } from '@/entities/Feed/store'

const feedStore = useFeedStore()

function fetch() {
    feedStore.fetchTimelineFeed()
}
</script>

<template>
    <post-feed
        id="timeline"
        window
        @fetch="fetch"
    />
</template>

<style scoped>

</style>
