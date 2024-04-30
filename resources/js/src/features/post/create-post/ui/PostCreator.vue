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
import UserUsername from '@/entities/User/ui/UserUsername.vue'
import { usePostStore } from '@/entities/Post/store'
import { useCreatePost } from '@/features/post/create-post/hook/useCreatePost'
import { useUserStore } from '@/entities/User/store'
import { useFilePicker } from '@/features/post/create-post/hook/useFilePicker'
import PostCreatorMedia from '@/features/post/create-post/ui/PostCreatorMedia/PostCreatorMedia.vue'
import PostEntity from '@/entities/Post/ui/PostEntity.vue'

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
        in_reply_to_post_id: props.inReplyToPostId,
        media: files.value
    }
})

const formIsValid = computed(() => {
    if (Boolean(createPostData.value.text.length)) return true
    if (Boolean(files.value.length)) return true

    return false
})

function clear() {
    if (props.useModalData) {
        createPostModel.setText('')
        createPostModel.setRetweetPostId(null)
        createPostModel.setCommentForPostId(null)
    } else {
        text.value = ''
    }

    clearFilePicker()
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

const {
    files,
    openFilePicker: openMediaFilePicker,
    clearFilePicker,
    deleteFile
} = useFilePicker({ maxFiles: 4, maxSize: 4000000 })

function deleteMediaHandler(index: number) {
    deleteFile(index)
}

</script>

<template>
    <div class="post-creator-wrapper">
        <div
            v-if="inReplyToPostId && inReplyToPost && useModalData"
            class="answer"
        >
            <post-entity
                :post="inReplyToPost"
                no-padding
                with-thread-line-below
            >
                <template #footer>
                    <div
                        v-if="inReplyToUser"
                        class="answer-to"
                    >
                        В ответ
                        <user-username :username="inReplyToUser.username" />
                    </div>
                </template>
            </post-entity>
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
                    <post-creator-media
                        v-if="files.length"
                        :media-files="files"
                        @delete-media="deleteMediaHandler"
                    />
                    <retweet-extensions
                        v-if="retweetForPostId"
                        :id="retweetForPostId"
                        :compact="Boolean(files.length)"
                    />
                </div>
                <post-creator-footer
                    :is-valid="formIsValid"
                    :text-length="formattedText.length"
                    :submit-button-text="submitButtonText"
                    :no-borders="noBorderInFooter"
                    :disable-open-media-file-picker-button="files.length === 4"
                    @publish="publishHandler"
                    @open-media-file-picker="openMediaFilePicker"
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
    padding-bottom: 0;
    position: relative;
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
    grid-gap: 10px;
    width: 100%;
}

.content {
    display: flex;
    flex-direction: column;
    grid-gap: 10px;
    overflow: auto;
}
</style>
