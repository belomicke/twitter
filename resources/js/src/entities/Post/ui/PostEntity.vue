<script setup lang="ts">
import { computed, PropType } from 'vue'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/entities/User/store'
import UserNames from '@/entities/User/ui/UserNames.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import PostBody from '@/entities/Post/ui/PostBody.vue'
import PostPublishDate from '@/entities/Post/ui/PostPublishDate.vue'
import UserUsername from '@/entities/User/ui/UserUsername.vue'
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
            <div class="header">
                <div class="title">
                    <user-names
                        :user="author"
                        inline
                        links
                    />
                    <span class="separator">·</span>
                    <post-publish-date :date="post.created_at" />
                </div>
                <div
                    v-if="post.in_reply_to_username && !noAnswer"
                    class="subtitle"
                >
                    Ответ
                    <user-username :username="post.in_reply_to_username" />
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
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>

<style scoped>
.post-entity {
    display: flex;
    grid-gap: 10px;
}

.header {
    display: flex;
    flex-direction: column;
    margin-bottom: 5px;
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

.separator {
    margin: 0 5px;
}

.content {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.actions {
    padding-top: 10px;
}
</style>
