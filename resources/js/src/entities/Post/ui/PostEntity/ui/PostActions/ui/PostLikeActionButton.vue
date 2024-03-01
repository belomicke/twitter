<script setup lang="ts">

import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'
import { PropType, ref, watch } from 'vue'
import { IPost } from '@/shared/api/types/models/Post'
import { useLikePost } from '@/shared/api/hook/posts/useLikePost'
import { useUnlikePost } from '@/shared/api/hook/posts/useUnlikePost'
import _ from 'lodash'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true,
    },
})

const isLiked = ref<boolean>(props.post?.liked)
const count = ref<number>(props.post?.likes_count)

watch(() => props.post, (newPost) => {
    isLiked.value = newPost?.liked
    count.value = Number(newPost?.likes_count) ?? 0
})

const { mutate: like } = useLikePost()
const { mutate: unlike } = useUnlikePost()

function likeHandler() {
    const value = !isLiked.value

    isLiked.value = value

    if (value) {
        count.value = count.value + 1
    } else {
        count.value = count.value - 1
    }

    debouncedLikeHandler(value)
}

const debouncedLikeHandler = _.debounce((value: boolean) => {
    if (isLiked.value === props.post?.liked) return

    if (value) {
        like(props.post?.id)
    } else {
        unlike(props.post?.id)
    }
}, 500)
</script>

<template>
    <x-icon-button
        icon="heart"
        :filled="isLiked"
        :active="isLiked"
        color="249, 24, 128"
        :count="count"
        @click="likeHandler"
    />
</template>
