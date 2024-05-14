<script setup lang="ts">

import { useMediaStore } from '@/entities/Media/store'
import { computed, PropType, ref } from 'vue'
import { storeToRefs } from 'pinia'
import MediaPostItem from '@/entities/Post/ui/MediaPostExtension/MediaPostItem.vue'
import { IPost } from '@/shared/api/types/models/Post'
import ModalMediaViewer from "@/entities/Media/ui/ModalMediaViewer.vue"

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    withModal: {
        type: Boolean,
        required: false,
        default: false
    }
})

const mediaStore = useMediaStore()
const { getPostMediaById } = storeToRefs(mediaStore)

const mediaList = computed(() => {
    return getPostMediaById.value(props.post.id)
})

const modalMediaViewerRef = ref<InstanceType<typeof ModalMediaViewer> | null>(null)

function openInModal(position: number) {
    if (!modalMediaViewerRef.value) return
    if (!props.withModal) return

    modalMediaViewerRef.value.open(position)
}
</script>

<template>
    <div
        v-if="mediaList && mediaList.length"
        class="media-post-extensions"
        :class="{
            'two-rows': mediaList.length >= 3
        }"
    >
        <div
            class="media-row"
            :class="{ 'multiple': mediaList.length >= 2 }"
        >
            <media-post-item
                :post="post"
                :media="mediaList[0]"
                :with-modal="withModal"
                @click.stop="openInModal(0)"
            />
            <media-post-item
                v-if="mediaList.length >= 2"
                :post="post"
                :media="mediaList[1]"
                :with-modal="withModal"
                @click.stop="openInModal(1)"
            />
        </div>
        <div
            v-if="mediaList.length >= 3"
            class="media-row"
            :class="{ 'multiple': mediaList.length >= 2 }"
        >
            <media-post-item
                v-if="mediaList.length >= 3"
                :post="post"
                :media="mediaList[2]"
                :with-modal="withModal"
                @click.stop="openInModal(2)"
            />
            <media-post-item
                v-if="mediaList.length === 4"
                :post="post"
                :media="mediaList[3]"
                :with-modal="withModal"
                @click.stop="openInModal(3)"
            />
        </div>
    </div>
    <modal-media-viewer
        v-if="post"
        ref="modalMediaViewerRef"
        :post="post"
    />
</template>

<style scoped>
.media-post-extensions {
    display: grid;
    grid-template-rows: 1fr;
    grid-gap: 2px;
    height: 100%;
    width: 100%;

    &.two-rows {
        grid-template-rows: repeat(2, 1fr);
    }
}

.media-row {
    display: flex;
    width: 100%;
    height: 100%;
    grid-gap: 2px;
}

.media-row.multiple {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
}
</style>
