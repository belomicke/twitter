<script setup lang="ts">
import { useFeedStore } from '@/entities/Feed/store'
import PostFeed from '@/entities/Feed/ui/PostFeed.vue'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

const feedStore = useFeedStore()

function fetch() {
    feedStore.fetchPostRepliesFeed(props.id)
}
</script>

<template>
    <div class="post-replies-feed">
        <post-feed
            :id="`post:${id}:replies`"
            window
            @fetch="fetch"
        />
    </div>
</template>

<style scoped>
.post-replies-feed {
    min-height: 600px;
}
</style>
