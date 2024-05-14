<script setup lang="ts">
import { computed, ref } from "vue"
import { storeToRefs } from "pinia"
import { usePostStore } from "@/entities/Post/store"
import { useMediaStore } from "@/entities/Media/store"
import ModalMediaViewer from "@/entities/Media/ui/ModalMediaViewer.vue"
import XIcon from "@/shared/ui/XIcon/XIcon.vue"

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

const postStore = usePostStore()
const { getPostById } = storeToRefs(postStore)

const post = computed(() => {
    return getPostById.value(props.id)
})

const mediaStore = useMediaStore()
const { getPostMediaById } = storeToRefs(mediaStore)

const mediaList = computed(() => {
    if (!post.value) return []

    return getPostMediaById.value(post.value.id)
})

const modalMediaViewerRef = ref<InstanceType<typeof ModalMediaViewer> | null>(null)

function openModalMediaItem() {
    if (!modalMediaViewerRef.value) return

    modalMediaViewerRef.value.open()
}
</script>

<template>
    <template v-if="post && mediaList">
        <div
            class="media-post-feed-item"
            :style="{
                'background-image': `url(${mediaList[0].path})`
            }"
            @click="openModalMediaItem"
        >
            <x-icon
                v-if="post.media_count > 1"
                icon="gallery"
                class="gallery-icon"
            />
        </div>
        <modal-media-viewer
            ref="modalMediaViewerRef"
            :post="post"
        />
    </template>
</template>

<style scoped>
.media-post-feed-item {
    cursor: pointer;
    background-size: cover;
    background-position: center;
    aspect-ratio: 1 / 1;
    position: relative;
}

.gallery-icon {
    position: absolute;
    bottom: 10px;
    right: 10px;
}
</style>
