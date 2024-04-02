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
    feedStore.fetchPostCommentsFeed(props.id)
}
</script>

<template>
    <div class="post-comments-feed">
        <post-feed
            :id="`post:${id}:comments`"
            window
            @fetch="fetch"
        />
    </div>
</template>

<style scoped>
.post-comments-feed {
    min-height: 600px;
}
</style>
