<script setup lang="ts">
import { computed, onMounted, PropType, ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import PostPagePost from './ui/PostPagePost.vue'
import CommentCreator from './ui/CommentCreator.vue'
import PostPageComment from './ui/PostPageComment.vue'
import PostPageAnswer from './ui/PostPageAnswer.vue'
import VirtualScroll from '@/pages/Post/ui/VirtualScroll.vue'
import { useFeedStore } from '@/entities/Feed/store'
import PostFeedItem from '@/entities/Feed/ui/PostFeedItem.vue'
import { IPost } from '@/shared/api/types/models/Post'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    element: {
        type: HTMLDivElement,
        required: true
    }
})

const pageIsVisible = ref<boolean>(false)
const commentsWithShowedAnswers = ref<number[]>([])
const virtualScrollRef = ref<InstanceType<typeof VirtualScroll> | null>(null)

const feedStore = useFeedStore()
const { getFeedById } = storeToRefs(feedStore)

const threadHistoryFeed = computed(() => {
    return getFeedById.value(`post:${props.post.id}:thread_history`)
})

const commentsFeed = computed(() => {
    return getFeedById.value(`post:${props.post.id}:comments`)
})

const topTriggerIsVisible = computed(() => {
    if (!threadHistoryFeed.value) return false

    return threadHistoryFeed.value.data.items.length !== threadHistoryFeed.value.data.total
})

const bottomTriggerIsVisible = computed(() => {
    if (!commentsFeed.value) return false

    return commentsFeed.value.data.items.length !== commentsFeed.value.data.total
})

const items = computed(() => {
    const result = ['page-post', 'comment-creator']

    if (threadHistoryFeed.value) {
        const threadHistoryItems = threadHistoryFeed.value.data.items.toReversed().map(item => `thread_history:${item}`)

        result.unshift(...threadHistoryItems)
    }

    if (commentsFeed.value) {
        let items: string[] = []

        commentsFeed.value.data.items.forEach(commentId => {
            items.push(`comment:${commentId}`)
            if (commentsWithShowedAnswers.value.indexOf(commentId) !== -1) {
                const feed = feedStore.getFeedById(`post:${commentId}:thread`)

                if (feed) {
                    const comments = feed.data.items.map(item => `comment:${item}:answer`)
                    items.push(...comments)
                }
            }
        })

        result.push(...items)
    }

    return result
})

onMounted(() => {
    pageInitHandler()
})

watch(() => props.post, () => {
    pageInitHandler()
})

const lastThreadHistoryItemId = ref<string>('')

function saveScrollPosition() {
    lastThreadHistoryItemId.value = items.value[0]
}

function restoreScrollPosition() {
    const vScroll = virtualScrollRef.value

    if (!vScroll) return

    const indexToScroll = items.value.indexOf(lastThreadHistoryItemId.value)

    vScroll.scrollToIndex(indexToScroll, { align: 'start' })
}

function showAnswers(id: number) {
    commentsWithShowedAnswers.value.push(id)
}

function getIsLastAnswerAttribute(index: number) {
    if (!items.value[index + 1]) return true

    return Boolean(items.value[index + 1].indexOf('answer') === -1)
}

function getRootPostInThreadId(id: string) {
    const index = items.value.indexOf(id)
    let rootPostInThreadId = 0

    for (let i = index; i >= 0; i--) {
        if (items.value[i].indexOf('answer') === -1) {
            rootPostInThreadId = Number(items.value[i].split(':')[1])
            break
        }
    }

    return rootPostInThreadId
}

function topTriggerHandler() {
    const feed = threadHistoryFeed.value

    if (!feed || !pageIsVisible.value) return
    if (feed.data.items.length === feed.data.total) return

    saveScrollPosition()

    feedStore.fetchPostThreadHistoryFeed(props.post.id).then(() => {
        restoreScrollPosition()
    })
}

function bottomTriggerHandler() {
    const feed = commentsFeed.value

    if (!feed || !pageIsVisible.value) return

    feedStore.fetchPostCommentsFeed(props.post.id)
}

async function fetchThreadHistoryFeedOnMounted() {
    const vScroll = virtualScrollRef.value

    if (!vScroll) return

    if (!threadHistoryFeed.value) {
        pageIsVisible.value = false

        await feedStore.fetchPostThreadHistoryFeed(props.post.id).then(() => {
            setTimeout(() => {
                vScroll.scrollToIndex(items.value.indexOf('page-post'), { align: 'start' })
                pageIsVisible.value = true
            }, 150)
        })
    } else {
        vScroll.scrollToIndex(items.value.indexOf('page-post'), { align: 'start' })
        pageIsVisible.value = true
    }
}

function pageInitHandler() {
    commentsWithShowedAnswers.value = []
    fetchThreadHistoryFeedOnMounted().then(() => {
        if (props.post?.reply_count) {
            feedStore.fetchPostCommentsFeed(props.post.id)
        }
    })
}
</script>

<template>
    <div
        class="wrapper"
        :class="{ 'visible': pageIsVisible }"
    >
        <virtual-scroll
            ref="virtualScrollRef"
            :element="element"
            :post="post"
            :items="items"
            :top-trigger-is-visible="topTriggerIsVisible"
            :bottom-trigger-is-visible="bottomTriggerIsVisible"
            @top-handler="topTriggerHandler"
            @bottom-handler="bottomTriggerHandler"
        >
            <template #default="{ virtualRow }">
                <post-page-post
                    v-if="items[virtualRow.index] === 'page-post'"
                    :id="post.id"
                    :has-thread="Boolean(items[virtualRow.index - 1])"
                />
                <comment-creator
                    v-else-if="items[virtualRow.index] === 'comment-creator'"
                    :post="post"
                />
                <post-feed-item
                    v-else-if="items[virtualRow.index].startsWith('thread_history')"
                    :id="Number(items[virtualRow.index].split(':')[1])"
                    is-thread
                    no-answer
                    :is-first-in-thread="items.indexOf(items[virtualRow.index]) === 0"
                />
                <post-page-answer
                    v-else-if="items[virtualRow.index].endsWith('answer')"
                    :id="Number(items[virtualRow.index].split(':')[1])"
                    :root-post-in-thread-id="getRootPostInThreadId(items[virtualRow.index])"
                    :is-last="getIsLastAnswerAttribute(virtualRow.index)"
                />
                <post-page-comment
                    v-else-if="items[virtualRow.index].startsWith('comment')"
                    :id="Number(items[virtualRow.index].split(':')[1])"
                    @show-comments="showAnswers"
                />
            </template>
        </virtual-scroll>
    </div>
    <div
        v-if="!pageIsVisible"
        class="loader"
    >
        <x-icon
            icon="loader"
            color="var(--x-color-primary)"
            :size="40"
        />
    </div>
    <div style="height: 80vh" />
</template>

<style scoped>
.wrapper {
    opacity: 0;
}

.wrapper.visible {
    opacity: 1;
}

.loader {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
    width: 100%;
}
</style>
