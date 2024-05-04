<script setup lang="ts">
import { PropType, ref } from 'vue'
import { Media } from '@/shared/api/types/models/Media'
import ModalMediaItem from '@/entities/Media/ui/ModalMediaItem.vue'
import { IPost } from '@/shared/api/types/models/Post'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    media: {
        type: Object as PropType<Media>,
        required: true
    },
    withModal: {
        type: Boolean,
        required: false,
        default: false
    }
})

const modalMediaItemRef = ref<InstanceType<typeof ModalMediaItem> | null>(null)

function openInModal() {
    if (!modalMediaItemRef.value) return
    if (!props.withModal) return

    modalMediaItemRef.value.open()
}
</script>

<template>
    <div
        v-if="media"
        class="wrapper"
        @click.stop="openInModal"
    >
        <div
            class="media"
            :style="{
                'background-image': `url(/${media.path})`,
                'aspect-ratio': `${media.width} / ${media.height}`
            }"
        />
    </div>
    <modal-media-item
        v-if="media && post"
        ref="modalMediaItemRef"
        :media="media"
        :post="post"
    />
</template>

<style scoped>
.wrapper {
    display: flex;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.media {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
}
</style>
