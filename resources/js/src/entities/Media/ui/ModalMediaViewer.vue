<script setup lang="ts">
import { computed, PropType, ref, watch } from 'vue'
import PostActions from '@/entities/Post/ui/PostActions.vue'
import { IPost } from '@/shared/api/types/models/Post'
import { useMediaStore } from "@/entities/Media/store"
import { storeToRefs } from "pinia"
import ModalMediaItem from "@/entities/Media/ui/ModalMediaItem.vue"
import XIconButton from "@/shared/ui/XIconButton/XIconButton.vue"

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    }
})

defineExpose({
    open,
    close
})

const mediaStore = useMediaStore()
const { getPostMediaById } = storeToRefs(mediaStore)

const mediaList = computed(() => {
    return getPostMediaById.value(props.post.id)
})

const isActive = ref<boolean>(false)
const isVisible = ref<boolean>(false)

function close() {
    activeMedia.value = 0
    isActive.value = false
    isVisible.value = false
}

function open(mediaNumber: number = 0) {
    activeMedia.value = mediaNumber
    isActive.value = true

    if (props.post?.media_count === 1 || mediaNumber === 0) {
        isVisible.value = true
    } else {
        setTimeout(() => isVisible.value = true, 150)
    }
}

const activeMedia = ref<number>(0)

watch(activeMedia, () => console.log(activeMedia.value))

function nextMedia() {
    if (activeMedia.value === mediaList.value.length - 1) {
        return
    }

    activeMedia.value++
}

function prevMedia() {
    if (activeMedia.value === 0) {
        return
    }

    activeMedia.value--
}
</script>

<template>
    <Teleport to="#portals">
        <div
            v-if="mediaList"
            class="wrapper"
            :class="{
                'active': isActive,
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
                    class="slider"
                    :style="{
                        'grid-template-columns': `repeat(${mediaList.length}, 100vw`,
                        'margin-left': `-${activeMedia * 100 * 2}vw`,
                        'transition': isActive ? 'margin-left .15s' : 'none'
                    }"
                >
                    <div class="arrows">
                        <x-icon-button
                            v-if="activeMedia !== 0"
                            class="arrow-left"
                            :size="20"
                            color="255, 255, 255"
                            color-hover="255, 255, 255"
                            background-color="0, 0, 0"
                            background-color-hover="26, 26, 26"
                            background-opacity=".75"
                            icon="arrow-left"
                            @click="prevMedia"
                        />
                        <x-icon-button
                            v-if="activeMedia !== mediaList.length - 1"
                            class="arrow-right"
                            :size="20"
                            color="255, 255, 255"
                            color-hover="255, 255, 255"
                            background-color="0, 0, 0"
                            background-color-hover="26, 26, 26"
                            background-opacity=".75"
                            icon="arrow-left"
                            @click="nextMedia"
                        />
                    </div>
                    <modal-media-item
                        v-for="media in mediaList"
                        :key="media.id"
                        :is-active="isActive"
                        :media="media"
                        :style="{
                            'opacity': isVisible ? '1' : '0'
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
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: var(--z-index-media-modal);
}

.wrapper.active {
    display: block;
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

.full-screen-media-footer {
    display: flex;
    align-items: center;
    max-width: 570px;
    width: 100%;
    margin: 0 auto;
    height: 46px;
}

.slider {
    display: grid;
    width: 100%;
    height: 100%;
}

.arrows {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.arrow-left {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 20px;
    z-index: 10004;
    pointer-events: all;
}

.arrow-right {
    position: absolute;
    top: 50%;
    transform: translateY(-50%) rotate(180deg);
    z-index: 10004;
    right: 20px;
    pointer-events: all;
}
</style>
