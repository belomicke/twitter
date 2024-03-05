<script setup lang="ts">
import { provide, reactive } from 'vue'

import { useRouter } from 'vue-router'

import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import { useViewerStore } from '@/entities/Viewer/store'
import PostCreatorTextarea from '@/widgets/PostCreator/PostCreatorTextarea.vue'
import PostCreatorFooter from '@/widgets/PostCreator/ui/PostCreatorFooter.vue'

defineProps({
    height: {
        type: Number,
        required: false,
        default: 68,
    },
})

const emit = defineEmits(['publish'])

const router = useRouter()

const viewerStore = useViewerStore()
const viewer = viewerStore.viewer

const postBody = reactive<CreatePostDTO>({
    text: '',
})

provide('postBody', postBody)

function goToProfile() {
    if (!viewer) return

    router.push(`/profile/${viewer.username}`)
}

function publishHandler() {
    postBody.text = ''
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
                    v-model="postBody.text"
                    placeholder="Что происходит?!"
                    :height="height"
                    :max-length="280"
                />
            </div>
            <post-creator-footer
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
    padding: 12px 16px 8px;
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
</style>
