<script setup lang="ts">
import { computed } from "vue"
import { storeToRefs } from "pinia"
import EmptyFeed from "@/entities/Feed/ui/EmptyFeed.vue"
import { useViewerStore } from "@/entities/Viewer/store"

const props = defineProps({
    username: {
        type: String,
        required: true
    }
})

const viewerStore = useViewerStore()
const { getViewer } = storeToRefs(viewerStore)

const viewer = computed(() => {
    return getViewer.value
})

const title = computed(() => {
    if (!viewer.value) return ''

    if (props.username === viewer.value.username) {
        return 'Свет, камера... прикрепленные файлы!'
    } else {
        return `@${props.username} пока не публиковал(а) медиафайлов`
    }
})

const subtitle = computed(() => {
    if (!viewer.value) return ''

    if (props.username === viewer.value.username) {
        return 'Когда вы опубликуете фотографии или видео, они появятся здесь.'
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
