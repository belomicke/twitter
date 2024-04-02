<script setup lang="ts">
import { computed, PropType, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'
import PostCreatorFooter from './PostCreatorFooter.vue'
import PostCreatorTextarea from './PostCreatorTextarea.vue'
import { useCreatePostModel } from '@/features/post/create-post/model'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import { useViewerStore } from '@/entities/Viewer/store'
import RetweetExtensions from '@/entities/Post/ui/RetweetExtensions.vue'
import PostFeedItem from '@/entities/Feed/ui/PostFeedItem.vue'
import UserUsername from '@/entities/User/ui/UserUsername.vue'
import { usePostStore } from '@/entities/Post/store'
import { useCreatePost } from '@/features/post/create-post/hook/useCreatePost'
import { useUserStore } from '@/entities/User/store'

const props = defineProps({
    inReplyToPostId: {
        type: null as unknown as PropType<number | null>,
        required: false,
        default: null
    },
    retweetForPostId: {
        type: null as unknown as PropType<number | null>,
        required: false,
        default: null
    },
    height: {
        type: Number,
        required: false,
        default: 68
    },
    useModalData: {
        type: Boolean,
        required: false,
        default: false
    },
    placeholder: {
        type: String,
        required: false,
        default: 'Что происходит?!'
    },
    submitButtonText: {
        type: String,
        required: false,
        default: 'Опубликовать'
    },
    noBorderInFooter: {
        type: Boolean,
        required: false,
        default: false
    }
})

const emit = defineEmits(['publish'])

defineExpose({
    clear
})

const router = useRouter()

const viewerStore = useViewerStore()
const viewer = viewerStore.viewer

const postStore = usePostStore()
const { getPostById } = storeToRefs(postStore)

const userStore = useUserStore()
const { getUserById } = storeToRefs(userStore)

const createPostModel = useCreatePostModel()
const { getText } = storeToRefs(createPostModel)

const text = ref<string>('')

const textValue = computed(() => {
    if (props.useModalData) {
        return getText.value
    } else {
        return text.value
    }
})

const formattedText = computed(() => {
    return textValue.value.replace(/\n+/g, '\n\n')
})

const inReplyToPost = computed(() => {
    if (!props.inReplyToPostId) return null

    return getPostById.value(props.inReplyToPostId)
})

const inReplyToUser = computed(() => {
    if (!inReplyToPost.value) return null

    return getUserById.value(inReplyToPost.value.user_id)
})

const { mutate: createPost } = useCreatePost()

const createPostData = computed(() => {
    return {
        text: formattedText.value,
        retweeted_post_id: props.retweetForPostId,
        in_reply_to_post_id: props.inReplyToPostId
    }
})

const formIsValid = computed(() => {
    return Boolean(createPostData.value.text.length)
})

function clear() {
    if (props.useModalData) {
        createPostModel.setText('')
        createPostModel.setRetweetPostId(null)
        createPostModel.setCommentForPostId(null)
    } else {
        text.value = ''
    }
}

function goToProfile() {
    if (!viewer) return

    router.push(`/profile/${viewer.username}`)
}

function onInput(value: string) {
    if (props.useModalData) {
        createPostModel.setText(value)
    } else {
        text.value = value
    }
}

function publishHandler() {
    if (!formIsValid.value) return

    createPost(createPostData.value)
    clear()
    emit('publish')
}
</script>

<template>
    <div class="post-creator-wrapper">
        <div
            v-if="inReplyToPostId && inReplyToPost && useModalData"
            class="answer"
        >
            <post-feed-item
                :id="inReplyToPostId"
                is-thread
                is-first-in-thread
                no-actions
                no-padding
                no-answer
                no-hover
            />
            <div
                v-if="inReplyToUser"
                class="answer-to"
            >
                В ответ
                <user-username :username="inReplyToUser.username" />
            </div>
        </div>
        <div
            v-if="viewer"
            class="post-creator"
        >
            <div class="avatar">
                <user-avatar
                    :username="viewer.username"
                    :size="40"
                    rounded
                    @click="goToProfile"
                />
            </div>
            <div class="body">
                <div class="content">
                    <post-creator-textarea
                        :model-value="textValue"
                        :placeholder="placeholder"
                        :height="height"
                        @update:model-value="onInput"
                    />
                    <div
                        v-if="retweetForPostId"
                        class="retweet"
                    >
                        <retweet-extensions
                            :id="retweetForPostId"
                        />
                    </div>
                </div>
                <post-creator-footer
                    :is-valid="formIsValid"
                    :text-length="formattedText.length"
                    :submit-button-text="submitButtonText"
                    :no-borders="noBorderInFooter"
                    @publish="publishHandler"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>
.post-creator-wrapper {
    display: flex;
    flex-direction: column;
    grid-gap: 20px;
    width: 100%;
}

.answer-to {
    color: rgb(113, 118, 123);
    line-height: 19px;
    font-size: 14px;
    font-weight: 400;

    padding-top: 10px;
    padding-left: 50px;
    padding-bottom: 0;
    position: relative;
}

.answer-to::before {
    content: "";
    width: 2px;
    background-color: var(--x-border-color);
    height: 100%;
    position: absolute;
    left: 19px;
    top: 0;
}

.post-creator {
    --avatar-width: 40px;
    --gap: 10px;
    --horizontal-padding: 16px;

    display: flex;
    grid-gap: 10px;
    width: 100%;
}

.avatar {
    display: flex;
    height: 40px;
    cursor: pointer;
}

.body {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.content {
    overflow: auto;
}

.retweet {
    margin: 20px 0 10px;
}
</style>
