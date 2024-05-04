<script setup lang="ts">

import { computed, PropType } from 'vue'
import { IPost } from '@/shared/api/types/models/Post'
import { useRetweetPost } from '@/features/post/retweet-post/hook/useRetweetPost'
import { useUndoRetweetPost } from '@/features/post/retweet-post/hook/useUndoRetweetPost'
import { useCreatePostModel } from '@/features/post/create-post/model'
import { useAppModalPostCreatorStore } from '@/entities/App/store/AppModalPostCreatorStore'
import XDropdownIconButton, { XDropdownIconButtonOption } from '@/shared/ui/XDropdownIconButton/XDropdownIconButton.vue'

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

const appStore = useAppModalPostCreatorStore()
const createPostModel = useCreatePostModel()

const isRetweeted = computed(() => {
    return props.post.retweeted
})

const count = computed(() => {
    return props.post?.retweet_count
})

const { mutate: retweet } = useRetweetPost()
const { mutate: undoRetweet } = useUndoRetweetPost()

function retweetHandler() {
    retweet(props.post.id)
}

function undoRetweetHandler() {
    undoRetweet(props.post.id)
}

function quoteHandler() {
    appStore.setModalPostCreatorIsOpen(true)
    createPostModel.setRetweetPostId(props.post.id)
}

const options = computed((): XDropdownIconButtonOption[] => {
    if (isRetweeted.value) {
        return [
            {
                icon: 'retweet',
                label: 'Отменить ретвит',
                action: undoRetweetHandler
            },
            {
                icon: 'edit',
                label: 'Цитата',
                action: quoteHandler
            }
        ]
    }

    return [
        {
            icon: 'retweet',
            label: 'Ретвит',
            action: retweetHandler
        },
        {
            icon: 'edit',
            label: 'Цитата',
            action: quoteHandler
        }
    ]
})

const color = computed(() => {
    if (isRetweeted.value) {
        return '0, 186, 124'
    } else {
        return props.color
    }
})
</script>

<template>
    <x-dropdown-icon-button
        :options="options"
        icon="retweet"
        :size="iconSize"
        :count="count"
        :active="isRetweeted"
        :filled="isRetweeted"

        :color="color"
        color-hover="0, 186, 124"

        background-color="transparent"
        background-color-hover="0, 186, 124"
    />
</template>

<style scoped>

</style>
