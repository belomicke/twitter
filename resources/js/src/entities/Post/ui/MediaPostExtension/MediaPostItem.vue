<script setup lang="ts">
import { PropType } from 'vue'
import { Media } from '@/shared/api/types/models/Media'

const props = defineProps({
    media: {
        type: Object as PropType<Media>,
        required: true
    }
})

</script>

<template>
    <div
        class="wrapper"
        @click.stop
    >
        <div
            class="media"
            :style="{
                'background-image': `url(/${media.path})`,
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
