<script setup lang="ts">

import { useMediaStore } from '@/entities/Media/store'
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import MediaPostItem from '@/entities/Post/ui/MediaPostExtension/MediaPostItem.vue'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

const mediaStore = useMediaStore()
const { getPostMediaById } = storeToRefs(mediaStore)

const mediaList = computed(() => {
    return getPostMediaById.value(props.id)
})
</script>

<template>
    <div
        v-if="mediaList && mediaList.length"
        class="media-post-extensions"
    >
        <div
            class="media-row"
            :class="{ 'multiple': mediaList.length >= 2 }"
        >
            <media-post-item
                :media="mediaList[0]"
            />
            <media-post-item
                v-if="mediaList.length >= 2"
                :media="mediaList[1]"
            />
        </div>
        <div
            v-if="mediaList.length >= 3"
            class="media-row"
            :class="{ 'multiple': mediaList.length >= 2 }"
        >
            <media-post-item
                v-if="mediaList.length >= 3"
                :media="mediaList[2]"
            />
            <media-post-item
                v-if="mediaList.length === 4"
                :media="mediaList[3]"
            />
        </div>
    </div>
</template>

<style scoped>
.media-post-extensions {
    display: flex;
    flex-direction: column;
    grid-gap: 2px;
    height: 100%;
    width: 100%;
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
