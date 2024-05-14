<script setup lang="ts">
import { useViewerStore } from "@/entities/Viewer/store"
import { computed } from "vue"
import EmptyFeed from "@/entities/Feed/ui/EmptyFeed.vue"

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
        return 'Вы пока не добавили ни одного поста в избранное'
    } else {
        return `@${props.username} пока не добавил ни одного поста в избранное`
    }
})

const subtitle = computed(() => {
    if (!viewerStore.viewer) return
    if (viewerStore.viewer.username === props.username) {
        return 'Когда вы добавите пост в избранное, он отобразится здесь.'
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
