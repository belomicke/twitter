<script setup lang="ts">
import { PropType } from 'vue'
import { Media } from '@/shared/api/types/models/Media'
import { IPost } from '@/shared/api/types/models/Post'

defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    media: {
        type: Object as PropType<Media>,
        required: true
    },
})
</script>

<template>
    <div
        v-if="media"
        class="wrapper"
    >
        <div
            class="media"
            :style="{
                'background-image': `url(${media.path})`,
                'aspect-ratio': `${media.width} / ${media.height}`
            }"
        />
    </div>
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
