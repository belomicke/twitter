<script setup lang="ts">

import { useMediaStore } from '@/entities/Media/store'
import { computed, PropType } from 'vue'
import { storeToRefs } from 'pinia'
import MediaPostItem from '@/entities/Post/ui/MediaPostExtension/MediaPostItem.vue'
import { IPost } from '@/shared/api/types/models/Post'

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
                :post="post"
                :media="mediaList[0]"
                :with-modal="withModal"
            />
            <media-post-item
                v-if="mediaList.length >= 2"
                :post="post"
                :media="mediaList[1]"
                :with-modal="withModal"
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
            />
            <media-post-item
                v-if="mediaList.length === 4"
                :post="post"
                :media="mediaList[3]"
                :with-modal="withModal"
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
