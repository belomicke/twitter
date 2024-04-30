<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'

const props = defineProps({
    file: {
        type: File,
        required: true
    }
})

const emit = defineEmits(['delete'])

const url = ref<string | undefined>()

const width = ref<number>(0)
const height = ref<number>(0)

const visible = ref<boolean>(false)

function getMediaFileSize(url: string) {
    const img = new Image()
    img.onload = function () {
        width.value = this.width
        height.value = this.height
        visible.value = true
    }
    img.src = url
}

function createUrlFromFile(file: File) {
    const blob = new Blob([file])
    url.value = URL.createObjectURL(blob)
    getMediaFileSize(url.value)
}

function deleteMedia() {
    emit('delete')
}

watch(() => props.file, (newMedia) => createUrlFromFile(newMedia), { deep: true })

onMounted(() => {
    createUrlFromFile(props.file)
})
</script>

<template>
    <div
        class="post-creator-media-item"
        :style="{
            'background-image': `url(${url})`,
            'aspect-ratio': `${width} / ${height}`,
            'opacity': visible ? 1 : 0
        }"
    >
        <div class="delete-button">
            <x-icon-button
                icon="cross"
                :size="17"

                color="255, 255, 255"
                color-hover="255, 255, 255"

                background-color="15, 20, 25"
                background-color-hover="63, 67, 71"

                background-opacity=".75"

                :padding="6"

                @click="deleteMedia"
            />
        </div>
    </div>
</template>

<style scoped>
.post-creator-media-item {
    display: flex;
    align-items: center;
    height: 100%;
    width: 100%;
    background-size: cover;
    position: relative;
    border-radius: 15px;
    overflow: hidden;
}

.post-creator-media-item + .post-creator-media-item {
    margin-left: 10px;
}

.delete-button {
    position: absolute;
    top: 10px;
    right: 10px;
}
</style>
