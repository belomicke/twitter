<script setup lang="ts">
import { computed, PropType } from 'vue'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/entities/User/store'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import PostBody from '@/entities/Post/ui/PostBody.vue'
import UserUsername from '@/entities/User/ui/UserUsername.vue'
import PostFeedItemHeaderTitle from '@/entities/Post/ui/PostFeedItemHeaderTitle.vue'
import { usePostStore } from '@/entities/Post/store'
import { IPost } from '@/shared/api/types/models/Post'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    noAnswer: {
        type: Boolean,
        required: false,
        default: false
    },
    noRedirect: {
        type: Boolean,
        required: false,
        default: false
    },
    noActions: {
        type: Boolean,
        required: false,
        default: false
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
    noPadding: {
        type: Boolean,
        required: false,
        default: false
    }
})
const router = useRouter()
const userStore = useUserStore()
const postStore = usePostStore()

const { getPostById } = storeToRefs(postStore)

const author = computed(() => {
    if (!props.post) return

    return userStore.getUserById(props.post.user_id)
})

const answerForUserId = computed(() => {
    if (props.noAnswer) return 0
    if (!props.post) return undefined
    if (!props.post.in_reply_to_post_id) return 0

    const post = getPostById.value(props.post.in_reply_to_post_id)

    if (!post) return 0

    return post.user_id
})

function goToPost() {
    if (props.noRedirect) return
    if (window.getSelection()?.getRangeAt(0).toString().length) return

    router.push(`/post/${props.post.id}`)
}
</script>

<template>
    <div
        class="wrapper"
        :class="{
            'no-padding': noPadding
        }"
    >
        <div
            v-if="withThreadLineAbove"
            class="thread-line above"
        />
        <div
            v-if="withThreadLineBelow"
            class="thread-line below"
        />
        <div
            v-if="author && answerForUserId !== undefined"
            class="post-entity"
            @click.stop="goToPost"
        >
            <div class="avatar">
                <user-avatar
                    :username="author.username"
                    :size="40"
                    rounded
                />
            </div>
            <div class="content">
                <div class="header container">
                    <div class="header-left">
                        <div class="title">
                            <post-feed-item-header-title :id="post.id" />
                        </div>
                        <div
                            v-if="post.in_reply_to_username && !noAnswer"
                            class="subtitle"
                        >
                            Ответ
                            <user-username :username="post.in_reply_to_username" />
                        </div>
                    </div>
                    <div class="header-right">
                        <slot name="header-right" />
                    </div>
                </div>
                <post-body
                    :post="post"
                    with-retweet
                />
                <div
                    v-if="!noActions"
                    class="actions"
                >
                    <slot name="footer" />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    --vertical-padding: 10px;
    --horizontal-padding: 15px;

    padding: var(--vertical-padding) var(--horizontal-padding);
    position: relative;
}

.wrapper.no-padding {
    --vertical-padding: 0px;
    --horizontal-padding: 0px;
}

.post-entity {
    display: flex;
    grid-gap: 10px;
}

.header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}

.header-left {
    display: flex;
    flex-direction: column;
}

.header-right {
    display: flex;
    align-items: center;
    height: 100%;
}

.title {
    display: flex;
    align-items: center;
    color: rgb(113, 118, 123);
    line-height: 19px;
    font-size: 14px;
    font-weight: 400;
}

.subtitle {
    color: rgb(113, 118, 123);
    font-feature-settings: "ss01";
    line-height: 20px;
    font-size: 15px;
    font-weight: 400;
    word-wrap: break-word;
    white-space: nowrap;
}

.content {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.actions {
    padding-top: 10px;
}

.thread-line {
    width: 2px;
    height: 100%;
    position: absolute;
    background-color: var(--x-border-color);
    left: calc(var(--horizontal-padding) + 19px);
    z-index: 0;
}

.thread-line.below {
    bottom: 0;
    height: calc(100% - var(--vertical-padding) - 40px - 5px);
}

.thread-line.above {
    top: 0;
    height: calc(10px - 5px);
}
</style>
