<script setup lang="ts">

import PostFeed from '@/entities/Feed/ui/PostFeed.vue'
import { useFeedStore } from '@/entities/Feed/store'
import TimelineEmptyFeed from '@/widgets/Feed/TimelineFeed/TimelineEmptyFeed.vue'

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
    >
        <timeline-empty-feed />
    </post-feed>
</template>

<style scoped>

</style>
