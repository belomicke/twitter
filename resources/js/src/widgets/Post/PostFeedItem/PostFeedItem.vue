<script setup lang="ts">
import { computed } from 'vue'
import PostFeedItemEntity from './PostFeedItemEntity.vue'
import RetweetedPostFeedItem from './RetweetedPostFeedItem.vue'
import PinnedPostFeedItem from './PinnedPostFeedItem.vue'
import { usePostStore } from '@/entities/Post/store'
import { storeToRefs } from 'pinia'
import DeletedPost from "@/entities/Post/ui/DeletedPost.vue"

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
    },
    noBorder: {
        type: Boolean,
        required: false,
        default: false
    },
    canBeDeleted: {
        type: Boolean,
        required: false,
        default: false,
    },

    withThreadLineAbove: {
        type: Boolean,
        required: false,
        default: false
    },
    withThreadLineBelow: {
        type: Boolean,
        required: false,
        default: false
    },
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

const isRetweet = computed(() => {
    return post.value &&
        retweetedPost.value &&
        post.value.retweeted_post_id !== 0 &&
        post.value.media_count === 0 &&
        post.value.text === ''
})

const isPinned = computed(() => {
    return props.canBePinned &&
        post.value &&
        post.value.is_pinned
})
</script>

<template>
    <div
        v-if="post"
        class="post-feed-item"
        :class="{
            'no-border': noBorder
        }"
    >
        <pinned-post-feed-item
            v-if="isPinned"
            :id="id"
            :with-options="withOptions"
            v-bind="$attrs"
        />
        <retweeted-post-feed-item
            v-else-if="isRetweet"
            :id="id"
            :with-options="withOptions"
            v-bind="$attrs"
        />
        <deleted-post
            v-else-if="canBeDeleted && post && post.is_deleted"
            :post="post"
            :with-thread-line-above="withThreadLineAbove"
            :with-thread-line-below="withThreadLineBelow"
            v-bind="$attrs"
        />
        <post-feed-item-entity
            v-else
            :id="id"
            :with-options="withOptions"
            :with-thread-line-above="withThreadLineAbove"
            :with-thread-line-below="withThreadLineBelow"
            v-bind="$attrs"
        />
    </div>
</template>

<style scoped>
.post-feed-item {
    border-bottom: 1px solid var(--x-border-color);
}

.post-feed-item.no-border {
    border-bottom: 0;
}
</style>
