<script setup lang="ts">
import { storeToRefs } from 'pinia'
import LeftSidebarFooter from './ui/LeftSidebarFooter/LeftSidebarFooter.vue'
import LeftSidebarNavigation from './ui/LeftSidebarNavigation/LeftSidebarNavigation.vue'
import { useViewerStore } from '@/entities/Viewer/store'

const viewerStore = useViewerStore()
const { viewer } = storeToRefs(viewerStore)

</script>

<template>
    <div
        v-if="viewer"
        class="left-sidebar"
    >
        <div class="body">
            <left-sidebar-navigation
                :user="viewer"
            />
        </div>
        <left-sidebar-footer
            :user="viewer"
        />
    </div>
</template>

<style scoped>
.left-sidebar {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100vh;
    padding: 5px 0;
    width: 100%;
}

.body {
    display: flex;
    flex-direction: column;
    grid-gap: 10px;
}
</style>
