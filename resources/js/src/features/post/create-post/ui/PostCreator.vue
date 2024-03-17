<script setup lang="ts">
import { computed, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'
import PostCreatorFooter from './PostCreatorFooter.vue'
import PostCreatorTextarea from './PostCreatorTextarea.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import { useViewerStore } from '@/entities/Viewer/store'
import RetweetExtensions from '@/entities/Post/ui/RetweetExtensions.vue'
import { useCreatePostModel } from '@/features/post/create-post/model'

const props = defineProps({
    height: {
        type: Number,
        required: false,
        default: 68
    },
    useModalData: {
        type: Boolean,
        required: false,
        default: false
    }
})

defineExpose({
    clear
})

const emit = defineEmits(['publish'])

const router = useRouter()

const viewerStore = useViewerStore()
const viewer = viewerStore.viewer

const createPostModel = useCreatePostModel()
const { getRetweetPostId, getText } = storeToRefs(createPostModel)

const text = ref<string>('')

const textValue = computed(() => {
    if (props.useModalData) {
        return getText.value
    } else {
        return text.value
    }
})

const retweetedPostId = computed(() => {
    if (props.useModalData) {
        return getRetweetPostId.value
    } else {
        return null
    }
})

const formattedText = computed(() => {
    return textValue.value.replace(/\n+/g, '\n\n')
})

const createPostData = computed(() => {
    return {
        text: formattedText.value ?? '',
        retweeted_post_id: retweetedPostId.value ?? null
    }
})

function clear() {
    if (props.useModalData) {
        createPostModel.setText('')
        createPostModel.setRetweetPostId(null)
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
    emit('publish')
}
</script>

<template>
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
                    placeholder="Что происходит?!"
                    :height="height"
                    @update:model-value="onInput"
                />
                <div
                    v-if="retweetedPostId"
                    class="retweet"
                >
                    <retweet-extensions
                        :id="retweetedPostId"
                    />
                </div>
            </div>
            <post-creator-footer
                :create-post-data="createPostData"
                @publish="publishHandler"
            />
        </div>
    </div>
</template>

<style scoped>
.post-creator {
    --avatar-width: 40px;
    --gap: 10px;
    --horizontal-padding: 16px;

    display: flex;
    grid-gap: 10px;
    padding: 10px 15px;
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
