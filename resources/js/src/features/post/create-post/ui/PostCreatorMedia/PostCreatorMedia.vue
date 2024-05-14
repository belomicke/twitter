<script setup lang="ts">

import { computed, PropType, ref, watch } from 'vue'
import PostCreatorMediaItem from './PostCreatorMediaItem.vue'
import PostCreatorMediaSlideButton from './PostCreatorMediaSlideButton.vue'

const props = defineProps({
    mediaFiles: {
        type: Array as PropType<File[]>,
        required: true
    }
})

const emit = defineEmits(['delete-media'])

const page = ref<0 | 1 | 2>(0)

watch(() => props.mediaFiles, () => {
    if (!props.mediaFiles) return

    if (props.mediaFiles.length === 3) {
        page.value = 1
    } else if (props.mediaFiles.length === 4) {
        page.value = 2
    }
}, { deep: true })

function goToPrevPage() {
    if (page.value !== 0) {
        page.value--
    }
}

function goToNextPage() {
    if (!canGoToNextPage.value) {
        return
    }

    page.value++
}

const canGoToNextPage = computed(() => {
    if (props.mediaFiles?.length === 3 && page.value === 1) {
        return false
    } else {
        return !(props.mediaFiles?.length === 4 && page.value === 2)
    }
})

function deleteMediaItem(index: number) {
    if (page.value === 2 && props.mediaFiles?.length === 4) {
        goToPrevPage()
    } else if (page.value === 1 && props.mediaFiles?.length === 3) {
        goToPrevPage()
    }

    emit('delete-media', index)
}
</script>

<template>
    <div
        class="media"
        :class="{ 'multiple-items': mediaFiles.length > 1 }"
        :style="{
            '--items-count': mediaFiles.length,
        }"
    >
        <div
            v-if="mediaFiles.length >= 3"
            class="buttons"
        >
            <div class="button">
                <post-creator-media-slide-button
                    v-if="page !== 0"
                    @click="goToPrevPage"
                />
            </div>
            <div class="button">
                <post-creator-media-slide-button
                    v-if="canGoToNextPage"
                    right
                    @click="goToNextPage"
                />
            </div>
        </div>
        <div
            class="list"
            :style="{
                'margin-left': mediaFiles.length >= 2 ?`-${264 * page}px` : 0
            }"
        >
            <div
                v-for="(file, index) in mediaFiles"
                :key="file.name"
                class="list-item"
            >
                <post-creator-media-item
                    :file="file"
                    @delete="deleteMediaItem(index)"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>
.media {
    --items-count: 0;
}

.media.multiple-items {
    display: flex;
    width: 100%;
    height: 254px;
    position: relative;
    overflow: hidden;
}

.media.multiple-items .list {
    display: flex;
    width: calc(254px * var(--items-count));
    height: 254px;
    position: absolute;
    z-index: 1;
    transition: margin-left .15s;
}

.media.multiple-items .list-item {
    display: flex;
    width: 254px;
    aspect-ratio: 1 / 1;
}

.list-item + .list-item {
    margin-left: 10px;
}

.buttons {
    width: 100%;
    display: flex;
    justify-content: space-between;
    pointer-events: none;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    padding: 0 10px;
    z-index: 2;
}
</style>
