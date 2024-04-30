<script setup lang="ts">
import { computed } from 'vue'
import PostFeedItemEntity from './PostFeedItemEntity.vue'
import RetweetedPostFeedItem from './RetweetedPostFeedItem.vue'
import PinnedPostFeedItem from './PinnedPostFeedItem.vue'
import { usePostStore } from '@/entities/Post/store'
import { storeToRefs } from 'pinia'

const props = defineProps({
    id: {
        type: Number,
        required: true
    },
    canBePinned: {
        type: Boolean,
        required: false,
        default: false
    },
    withOptions: {
        type: Boolean,
        required: false,
        default: false
    }
})

const postStore = usePostStore()
const { getPostById } = storeToRefs(postStore)

const post = computed(() => {
    return getPostById.value(props.id)
})

const retweetedPost = computed(() => {
    if (!post.value) return
    if (!post.value.retweeted_post_id) return

    return getPostById.value(post.value.retweeted_post_id)
})

const isDefaultPost = computed(() => {
    if (!post.value) return false
    if (post.value && post.value.retweeted_post_id !== null) return false

    return true
})

const isRetweet = computed(() => {
    return post.value && retweetedPost.value && post.value.retweeted_post_id !== 0 && post.value.media_count === 0 && post.value.text === ''
})

const isPinned = computed(() => {
    return props.canBePinned && post.value && post.value.is_pinned
})
</script>

<template>
    <div
        v-if="Boolean(isDefaultPost || isRetweet)"
        class="post-feed-item"
    >
        <pinned-post-feed-item
            v-if="isPinned"
            :id="id"
            :with-options="withOptions"
        />
        <retweeted-post-feed-item
            v-else-if="isRetweet"
            :id="id"
            :with-options="withOptions"
        />
        <post-feed-item-entity
            v-else
            :id="id"
            :with-options="withOptions"
        />
    </div>
</template>

<style scoped>
.post-feed-item {
    border-bottom: 1px solid var(--x-border-color);
}
</style>
