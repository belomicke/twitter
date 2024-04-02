<script setup lang="ts">
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import PostExtraStatus from '@/entities/Post/ui/PostExtraStatus.vue'
import PostActions from '@/entities/Post/ui/PostActions.vue'
import PostEntity from '@/entities/Post/ui/PostEntity.vue'

const props = defineProps({
    id: {
        type: Number,
        required: true
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
    noPadding: {
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

const router = useRouter()

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

    if (post.value.text.length) {
        return post.value
    } else if (post.value.retweeted_post_id && retweetedPost.value) {
        return retweetedPost.value
    } else {
        return post.value
    }
})

function goToRetweeter() {
    const retweeter = author.value

    if (!retweeter) return

    router.push(`/profile/${retweeter.username}`)
}


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
            'no-hover': noHover,
            'no-padding': noPadding
        }"
        @click="clickHandler"
    >
        <div
            v-if="isThread && !isFirstInThread"
            class="thread-line before"
        />
        <div
            v-if="isThread || isThreadIfHaveComments && post.reply_count"
            class="thread-line after"
        />
        <post-extra-status
            v-if="retweetedPost && post.text.length === 0"
            :text="`${author.name} сделал(-а) репост`"
            with-underline
            icon="retweet"
            @click="goToRetweeter"
        />
        <div
            class="entity"
            :class="{ 'no-padding': noPadding }"
        >
            <post-entity
                v-if="postToRender"
                :no-answer="noAnswer"
                :post="postToRender"
                :no-redirect="noHover"
                :no-actions="noActions"
            >
                <template #actions>
                    <post-actions
                        :post="postToRender"
                    />
                </template>
            </post-entity>
        </div>
    </div>
</template>

<style scoped>
.post {
    --vertical-padding: 10px;
    --horizontal-padding: 15px;
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

.post.no-padding {
    --horizontal-padding: 0px;
    --vertical-padding: 0px;
}

.thread-line {
    width: 2px;
    height: 100%;
    position: absolute;
    background-color: var(--x-border-color);
    left: calc(var(--horizontal-padding) + 19px);
    z-index: 0;
}

.thread-line.after {
    bottom: 0;
    height: calc(100% - var(--vertical-padding) - 40px - 5px);
}

.thread-line.before {
    top: 0;
    height: calc(10px - 5px);
}

.entity {
    padding: 10px 15px;
    position: relative;
    z-index: 0;
}

.entity.no-padding {
    padding: 0;
}
</style>
