<script setup lang="ts">
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import { useViewerStore } from '@/entities/Viewer/store'
import XPageHeader from '@/shared/ui/XPageHeader/XPageHeader.vue'
import BookmarkedPostsFeed from '@/widgets/Feed/BookmarkedPostsFeed/BookmarkedPostsFeed.vue'

const viewerStore = useViewerStore()
const { getViewer } = storeToRefs(viewerStore)

const viewer = computed(() => {
    return getViewer.value
})
</script>

<template>
    <x-page-header v-if="viewer">
        <div class="header-content">
            <div class="title">
                Закладки
            </div>
            <div class="subtitle">
                @{{ viewer.username }}
            </div>
        </div>
    </x-page-header>
    <bookmarked-posts-feed />
</template>

<style scoped>
.header-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

.title {
    color: rgb(231, 233, 234);
    font-size: 20px;
    line-height: 24px;
    font-weight: 700;
}

.subtitle {
    font-size: 13px;
    line-height: 16px;
    color: rgb(113, 118, 123);
}
</style>
