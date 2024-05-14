<script setup lang="ts">
import { onMounted, PropType, ref, watch } from "vue"
import { Media } from "@/shared/api/types/models/Media"

const props = defineProps({
    media: {
        type: Object as PropType<Media>,
        required: true
    },
    isActive: {
        type: Boolean,
        required: true
    }
})

const mediaItemRef = ref<HTMLDivElement | null>(null)
const mediaContainerRef = ref<HTMLDivElement | null>(null)

const originWidth = ref<number>(0)
const originHeight = ref<number>(0)

const width = ref<string>(props.media?.width > props.media?.height ? '100%' : 'unset')
const height = ref<string>(props.media?.width > props.media?.height ? 'unset' : '100%')

watch(() => props.isActive, calculateImageWidthAndHeight)

onMounted(() => {
    calculateImageWidthAndHeight()

    window.addEventListener('resize', () => {
        calculateImageWidthAndHeight()
    })

    const el = mediaItemRef.value

    if (!el) return

    originWidth.value = el.offsetWidth
    originHeight.value = el.offsetHeight
})

function calculateImageWidthAndHeight() {
    const item = mediaItemRef.value
    const container = mediaContainerRef.value

    if (!item) return
    if (!container) return

    const screenWidthIsBiggerThanOrigin = container.offsetWidth >= originWidth.value
    const screenHeightIsBiggerThanOrigin = container.offsetHeight >= originHeight.value

    if (screenWidthIsBiggerThanOrigin && screenHeightIsBiggerThanOrigin) {
        if (originWidth.value > originHeight.value) {
            setPriorityOnWidth()
        } else {
            setPriorityOnHeight()
        }
    } else if (screenWidthIsBiggerThanOrigin && !screenHeightIsBiggerThanOrigin) {
        setPriorityOnHeight()
    } else if (!screenWidthIsBiggerThanOrigin && screenHeightIsBiggerThanOrigin) {
        setPriorityOnWidth()
    } else {
        if (originWidth.value > originHeight.value) {
            setPriorityOnWidth()
        } else {
            setPriorityOnHeight()
        }
    }
}

function setPriorityOnWidth() {
    width.value = '100%'
    height.value = 'unset'
}

function setPriorityOnHeight() {
    width.value = 'unset'
    height.value = '100%'
}
</script>

<template>
    <div
        ref="mediaContainerRef"
        class="modal-media-item-container"
    >
        <div
            ref="mediaItemRef"
            class="modal-media-item"
            :style="{
                'background-image': `url(${media.path})`,
                'aspect-ratio': `${media.width} / ${media.height}`,
                'max-width': media.width,
                'height': height,
                'width': width
            }"
        />
    </div>
</template>

<style scoped>
.modal-media-item-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    max-height: calc(100vh - 46px);
}

.modal-media-item {
    background-size: cover;
    background-position: center;
    position: relative;
    z-index: 10000;
}
</style>
