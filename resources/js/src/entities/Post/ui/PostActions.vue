<script setup lang="ts">
import { PropType } from 'vue'
import { PostLikeActionButton } from '@/features/post/like-post'
import { PostRetweetActionButton } from '@/features/post/retweet-post'
import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'
import { IPost } from '@/shared/api/types/models/Post'
import { useAppModalPostCreatorStore } from '@/entities/App/store/AppModalPostCreatorStore'
import { useCreatePostModel } from '@/features/post/create-post/model'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    iconSize: {
        type: Number,
        required: false,
        default: 18
    },
    color: {
        type: String,
        required: false,
        default: '113, 118, 123'
    }
})

const modalPostCreatorStore = useAppModalPostCreatorStore()
const createPostModel = useCreatePostModel()

function commentPost() {
    if (!props.post) return

    modalPostCreatorStore.setModalPostCreatorIsOpen(true)
    createPostModel.setCommentForPostId(props.post.id)
}
</script>

<template>
    <div class="post-actions">
        <div class="post-action-button">
            <x-icon-button
                icon="comment"
                :size="iconSize"
                :color="color"
                color-hover="30, 155, 240"
                background-color-hover="30, 155, 240"
                :count="post.reply_count"
                @click.stop="commentPost"
            />
        </div>
        <div class="post-action-button">
            <post-retweet-action-button
                :post="post"
                :icon-size="iconSize"
                :color="color"
            />
        </div>
        <div class="post-action-button">
            <post-like-action-button
                :post="post"
                :icon-size="iconSize"
                :color="color"
            />
        </div>
    </div>
</template>

<style scoped>
.post-actions {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 40px;
    justify-content: start;
    width: 100%;
}

.post-action-button {
    display: flex;
    justify-content: start;
}
</style>
