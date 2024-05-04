<script setup lang="ts">
import { onMounted, PropType, ref } from 'vue'
import { Media } from '@/shared/api/types/models/Media'
import PostActions from '@/entities/Post/ui/PostActions.vue'
import { IPost } from '@/shared/api/types/models/Post'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    media: {
        type: Object as PropType<Media>,
        required: true
    }
})

defineExpose({
    open,
    close
})

const isVisible = ref<boolean>(false)

function close() {
    isVisible.value = false
}

function open() {
    isVisible.value = true
}

const mediaItemRef = ref<HTMLDivElement | null>(null)
const mediaContainerRef = ref<HTMLDivElement | null>(null)

const originWidth = ref<number>(0)
const originHeight = ref<number>(0)

const width = ref<string>(props.media?.width > props.media?.height ? '100%' : 'unset')
const height = ref<string>(props.media?.width > props.media?.height ? 'unset' : '100%')

onMounted(() => {
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
            setPriorityOnHeight()
        } else {
            setPriorityOnWidth()
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
    <Teleport to="#portals">
        <div
            class="wrapper"
            :class="{
                'active': isVisible,
            }"
        >
            <div
                class="background"
                @click="close"
            />
            <div class="full-screen-media">
                <div
                    class="background"
                    style="background-color: transparent"
                    @click="close"
                />
                <div
                    ref="mediaContainerRef"
                    class="full-screen-media-item-container"
                >
                    <div
                        ref="mediaItemRef"
                        class="full-screen-media-item"
                        :style="{
                            'background-image': `url(/${media.path})`,
                            'aspect-ratio': `${media.width} / ${media.height}`,
                            'max-width': media.width,
                            'height': height,
                            'width': width,
                        }"
                    />
                </div>
                <div class="full-screen-media-footer">
                    <post-actions
                        :post="post"
                        :color="`255, 255, 255`"
                    />
                </div>
            </div>
        </div>
    </Teleport>
</template>

<style scoped>
.wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    pointer-events: none;
    z-index: var(--z-index-media-modal);
}

.wrapper.active {
    opacity: 1;
    pointer-events: all;
}

.background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(91, 112, 131, 0.4);
}

.full-screen-media {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 100%;
    position: relative;
}

.full-screen-media-item-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    max-height: calc(100vh - 46px);
}

.full-screen-media-item {
    background-size: cover;
    background-position: center;
    position: relative;
    z-index: 10000;
}

.full-screen-media-footer {
    display: flex;
    align-items: center;
    max-width: 570px;
    width: 100%;
    margin: 0 auto;
    height: 46px;
}
</style>
