<script setup lang="ts">

import PostFeedItem from '@/entities/Feed/ui/PostFeedItem.vue'
import { storeToRefs } from 'pinia'
import { computed, ref } from 'vue'
import { useFeedStore } from '@/entities/Feed/store'
import LoadMoreButton from '@/entities/Post/ui/LoadMoreButton.vue'

const props = defineProps({
    id: {
        type: Number,
        required: true
    },
    isLast: {
        type: Boolean,
        required: true
    },
    rootPostInThreadId: {
        type: Number,
        required: true
    }
})

const feedStore = useFeedStore()
const { getFeedById } = storeToRefs(feedStore)

const feed = computed(() => {
    return getFeedById.value(`post:${props.rootPostInThreadId}:thread`)
})

const loadMoreButtonRef = ref<InstanceType<typeof LoadMoreButton> | null>(null)

const isLastInFeed = computed(() => {
    if (!feed.value) return false
    if (feed.value.data.total !== feed.value.data.items.length) return false
    return props.id === feed.value.data.items.at(-1)
})

function getMore() {
    const button = loadMoreButtonRef.value

    if (!button) return

    button.startLoading()
    feedStore.fetchPostThreadFeed(props.rootPostInThreadId).then(() => {
        button.stopLoading()
    })
}
</script>

<template>
    <div
        class="comment"
        :class="{ 'with-border': isLast }"
        v-bind="$attrs"
    >
        <div class="post">
            <div class="thread-line before" />
            <div
                v-if="!isLastInFeed"
                class="thread-line after"
            />
            <post-feed-item :id="id" />
        </div>
        <load-more-button
            v-if="isLast && !isLastInFeed"
            :id="rootPostInThreadId"
            ref="loadMoreButtonRef"
            @click="getMore"
        />
    </div>
</template>

<style scoped>
.comment.with-border {
    border-bottom: 1px solid var(--x-border-color);
}

.post {
    position: relative;
}

.thread-line {
    width: 2px;
    height: 100%;
    position: absolute;
    background-color: var(--x-border-color);
    left: calc(15px + 19px);
    z-index: 0;
}

.thread-line.after {
    bottom: 0;
    height: calc(100% - 10px - 40px - 5px);
}

.thread-line.before {
    top: 0;
    height: calc(10px - 5px);
}
</style>
