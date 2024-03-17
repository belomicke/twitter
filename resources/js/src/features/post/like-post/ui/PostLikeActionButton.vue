<script setup lang="ts">

import { PropType, ref, watch } from 'vue'
import _ from 'lodash'
import { useLikePost } from '../hook/useLikePost'
import { useUnlikePost } from '../hook/useUnlikePost'
import { usePostStore } from '@/entities/Post/store'
import { useViewerStore } from '@/entities/Viewer/store'
import { IPost } from '@/shared/api/types/models/Post'
import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true,
    },
    iconSize: {
        type: Number,
        required: true,
    },
})

const isLiked = ref<boolean>(props.post?.liked)
const count = ref<number>(props.post?.likes_count)

const postStore = usePostStore()
const viewerStore = useViewerStore()

watch(() => props.post, (newPost) => {
    isLiked.value = newPost?.liked
    count.value = Number(newPost?.likes_count) ?? 0
})

const { mutate: like } = useLikePost()
const { mutate: unlike } = useUnlikePost()

function likeHandler() {
    const value = !props.post?.liked

    if (value) {
        postStore.likePost(props.post.id)
        viewerStore.incrementFavouritesCount()
    } else {
        postStore.unlikePost(props.post.id)
        viewerStore.decrementFavouritesCount()
    }

    debouncedLikeHandler(value)
}

const debouncedLikeHandler = _.debounce((value: boolean) => {
    if (isLiked.value === props.post?.liked) return

    if (value) {
        like(props.post?.id, {
            onSuccess() {
                count.value += 1
                isLiked.value = true
            },
        })
    } else {
        unlike(props.post?.id, {
            onSuccess() {
                count.value -= 1
                isLiked.value = false
            },
        })
    }
}, 500)
</script>

<template>
    <x-icon-button
        icon="heart"
        :filled="post.liked"
        :size="iconSize"
        :active="post.liked"
        color="249, 24, 128"
        :count="post.likes_count"
        @click.stop="likeHandler"
    />
</template>
