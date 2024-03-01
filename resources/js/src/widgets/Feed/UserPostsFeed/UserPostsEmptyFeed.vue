<script setup lang="ts">
import { useViewerStore } from '@/entities/Viewer/store'
import { computed } from 'vue'
import EmptyFeed from '@/entities/Feed/ui/EmptyFeed.vue'

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
        return 'Вы пока не опубликовали ни одного поста'
    } else {
        return `@${props.username} пока не опубликовал ни одного поста`
    }
})

const subtitle = computed(() => {
    if (!viewerStore.viewer) return
    if (viewerStore.viewer.username === props.username) {
        return 'Напишите чем хотите поделиться на главной странице.'
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

<style scoped>

</style>
