<script setup lang="ts">

import { computed } from 'vue'
import EmptyFeed from '@/entities/Feed/ui/EmptyFeed.vue'
import { useViewerStore } from '@/entities/Viewer/store'

const props = defineProps({
    username: {
        type: String,
        required: true,
    },
})

const viewerStore = useViewerStore()

const title = computed(() => {
    if (!viewerStore.viewer) return
    if (viewerStore.viewer.username === props.username) {
        return 'Вы пока не ставили отметок «Нравится»'
    } else {
        return `@${props.username} пока не понравился ни один пост`
    }
})

const subtitle = computed(() => {
    if (!viewerStore.viewer) return
    if (viewerStore.viewer.username === props.username) {
        return 'Нажмите сердечко в любом посте, чтобы показать, что он вам нравится. Понравившиеся вам посты будут отображаться здесь.'
    } else {
        return 'Когда это произойдет, такие посты появятся здесь.'
    }
})
</script>

<template>
    <empty-feed
        :title="title"
        :subtitle="subtitle"
    />
</template>
