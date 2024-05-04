<script setup lang="ts">
import { computed, PropType } from 'vue'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import PostExtraStatus from '@/entities/Post/ui/PostExtraStatus.vue'
import PostActions from '@/entities/Post/ui/PostActions.vue'
import PostEntity from '@/entities/Post/ui/PostEntity.vue'
import { IconNames } from '@/shared/ui/XIcon'
import PostOptions from '@/entities/Post/ui/PostOptions/PostOptions.vue'

export interface PostFeedItemExtraStatusOptions {
    visible: boolean
    text: string
    icon: IconNames
    iconIsFilled?: boolean
    withUnderline?: boolean
    action?: () => void
}

const props = defineProps({
    id: {
        type: Number,
        required: true
    },
    withOptions: {
        type: Boolean,
        required: false,
        default: false
    },
    extraStatusOptions: {
        type: Object as PropType<PostFeedItemExtraStatusOptions>,
        required: false,
        default: undefined
    },


    isThread: {
        type: Boolean,
        required: false,
        default: false
    },
    isFirstInThread: {
        type: Boolean,
        required: false,
        default: false
    },
    isThreadIfHaveComments: {
        type: Boolean,
        required: false,
        default: false
    },
    noAnswer: {
        type: Boolean,
        required: false,
        default: false
    },
    noHover: {
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

const postStore = usePostStore()
const userStore = useUserStore()

const post = computed(() => {
    return postStore.getPostById(props.id)
})

const author = computed(() => {
    if (!post.value) return

    return userStore.getUserById(post.value.user_id)
})

const retweetedPost = computed(() => {
    if (!post.value) return null
    if (!post.value.retweeted_post_id) return null

    return postStore.getPostById(post.value.retweeted_post_id)
})

const postToRender = computed(() => {
    if (!post.value) return

    if (post.value.text.length || post.value.media_count > 0) {
        return post.value
    } else if (post.value.retweeted_post_id && retweetedPost.value) {
        return retweetedPost.value
    } else {
        return post.value
    }
})

function clickHandler(e: MouseEvent) {
    if (props.noHover) {
        e.stopPropagation()
    }
}
</script>

<template>
    <div
        v-if="post && author"
        class="post"
        :class="{
            'no-hover': noHover
        }"
        @click="clickHandler"
    >
        <post-extra-status
            v-if="extraStatusOptions && extraStatusOptions.visible"
            :text="extraStatusOptions.text"
            :with-underline="extraStatusOptions.withUnderline"
            :icon="extraStatusOptions.icon"
            :icon-is-filled="extraStatusOptions.iconIsFilled"
            @click="extraStatusOptions.action"
        />
        <post-entity
            v-if="postToRender"
            :no-answer="noAnswer"
            :post="postToRender"
            :no-redirect="noHover"
            :no-actions="noActions"
            with-media-modal
            clickable-username

            :with-thread-line-above="Boolean(isThread && !isFirstInThread)"
            :with-thread-line-below="Boolean(isThread || isThreadIfHaveComments && post.reply_count)"
        >
            <template #header-right>
                <post-options :post="post" />
            </template>
            <template #footer>
                <post-actions
                    :post="postToRender"
                />
            </template>
        </post-entity>
    </div>
</template>

<style scoped>
.post {
    cursor: pointer;
    position: relative;
    transition: background-color 0.15s;
}

.post:hover {
    background-color: rgba(255, 255, 255, 0.03);
}

.post.no-hover {
    cursor: default;
}

.post.no-hover:hover {
    background-color: transparent;
}
</style>
