<script setup lang="ts">
import { computed, ref } from 'vue'
import { storeToRefs } from 'pinia'
import PostFeedItem from '@/entities/Feed/ui/PostFeedItem.vue'
import { usePostStore } from '@/entities/Post/store'
import LoadMoreButton from '@/entities/Post/ui/LoadMoreButton.vue'
import { useFeedStore } from '@/entities/Feed/store'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

const emit = defineEmits(['show-comments'])

const postStore = usePostStore()
const { getPostById } = storeToRefs(postStore)

const post = computed(() => {
    return getPostById.value(props.id)
})

const feedStore = useFeedStore()
const { getFeedById } = storeToRefs(feedStore)

const feed = computed(() => {
    return getFeedById.value(`post:${props.id}:thread`)
})

const showComments = ref<boolean>(false)
const loadMoreButtonRef = ref<InstanceType<typeof LoadMoreButton> | null>(null)

function loadComments(e: MouseEvent) {
    e.stopPropagation()
    const button = loadMoreButtonRef.value

    if (!button) return

    button.startLoading()

    if (!feed.value) {
        feedStore.fetchPostThreadFeed(props.id).then(() => {
            showComments.value = true
            button.stopLoading()
            emit('show-comments', props.id)
        })
    } else {
        showComments.value = true
        button.stopLoading()
        emit('show-comments', props.id)
    }
}

</script>

<template>
    <div
        v-if="post"
        class="comment"
        :class="{
            'no-border': showComments
        }"
    >
        <post-feed-item
            :id="id"
            no-answer
            is-thread-if-have-comments
        />
        <load-more-button
            v-if="!showComments && post.reply_count"
            :id="id"
            ref="loadMoreButtonRef"
            @click="loadComments"
        />
    </div>
</template>

<style scoped>
.comment {
    border-bottom: 1px solid var(--x-border-color);
}

.comment.no-border {
    border: 0;
}
</style>
