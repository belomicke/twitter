<script setup lang="ts">

import { computed, PropType, ref, watch } from 'vue'
import _ from 'lodash'
import { usePostStore } from '@/entities/Post/store'
import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'
import { IPost } from '@/shared/api/types/models/Post'
import { useBookmarkPost } from '../hook/useBookmarkPost'
import { useUnbookmarkPost } from '../hook/useUnbookmarkPost'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    iconSize: {
        type: Number,
        required: true
    },
    color: {
        type: String,
        required: false,
        default: '113, 118, 123'
    }
})

const isBookmarked = ref<boolean>(props.post?.bookmarked)

const postStore = usePostStore()

const { mutate: bookmark } = useBookmarkPost()
const { mutate: unbookmark } = useUnbookmarkPost()

const color = computed(() => {
    if (!props.post) return undefined

    if (props.post.bookmarked) {
        return '30, 155, 240'
    } else {
        return props.color
    }
})

watch(() => props.post, (newPost) => {
    isBookmarked.value = newPost?.liked
})

function bookmarkHandler() {
    const value = !props.post?.bookmarked

    if (value) {
        postStore.bookmarkPost(props.post.id)
    } else {
        postStore.unbookmarkPost(props.post.id)
    }

    debouncedBookmarkHandler(value)
}

const debouncedBookmarkHandler = _.debounce((value: boolean) => {
    if (isBookmarked.value === props.post?.bookmarked) return

    if (value) {
        bookmark(props.post?.id, {
            onSuccess() {
                isBookmarked.value = true
            }
        })
    } else {
        unbookmark(props.post?.id, {
            onSuccess() {
                isBookmarked.value = false
            }
        })
    }
}, 500)

</script>

<template>
    <x-icon-button
        icon="bookmark"
        :filled="post.bookmarked"
        :size="iconSize"
        :active="post.bookmarked"

        :color="color"
        color-hover="30, 155, 240"

        background-color-hover="30, 155, 240"

        @click.stop="bookmarkHandler"
    />
</template>

<style scoped>

</style>
