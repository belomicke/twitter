<script setup lang="ts">

import { computed, PropType, ref, watch } from 'vue'
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
        required: true
    },
    iconSize: {
        type: Number,
        required: true
    }
})

const isLiked = ref<boolean>(props.post?.favorited)
const count = ref<number>(props.post?.favorite_count)

const postStore = usePostStore()
const viewerStore = useViewerStore()

watch(() => props.post, (newPost) => {
    isLiked.value = newPost?.favorited
    count.value = Number(newPost?.favorite_count) ?? 0
})

const { mutate: like } = useLikePost()
const { mutate: unlike } = useUnlikePost()

function likeHandler() {
    const value = !props.post?.favorited

    if (value) {
        postStore.likePost(props.post.id)
        viewerStore.incrementFavoritesCount()
    } else {
        postStore.unlikePost(props.post.id)
        viewerStore.decrementFavoritesCount()
    }

    debouncedLikeHandler(value)
}

const debouncedLikeHandler = _.debounce((value: boolean) => {
    if (isLiked.value === props.post?.favorited) return

    if (value) {
        like(props.post?.id, {
            onSuccess() {
                count.value += 1
                isLiked.value = true
            }
        })
    } else {
        unlike(props.post?.id, {
            onSuccess() {
                count.value -= 1
                isLiked.value = false
            }
        })
    }
}, 500)

const color = computed(() => {
    if (!props.post) return undefined
    
    if (props.post.favorited) {
        return '249, 24, 128'
    } else {
        return undefined
    }
})
</script>

<template>
    <x-icon-button
        icon="heart"
        :filled="post.favorited"
        :size="iconSize"
        :active="post.favorited"

        :color="color"
        color-hover="249, 24, 128"

        background-color-hover="249, 24, 128"
        :count="post.favorite_count"
        @click.stop="likeHandler"
    />
</template>
