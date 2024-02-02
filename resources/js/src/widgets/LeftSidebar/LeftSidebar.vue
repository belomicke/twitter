<script setup lang="ts">
import { storeToRefs } from 'pinia'
import LeftSidebarFooter from './ui/LeftSidebarFooter/LeftSidebarFooter.vue'
import LeftSidebarNavigation from './ui/LeftSidebarNavigation/LeftSidebarNavigation.vue'
import LeftSidebarLogo from './ui/LeftSidebarLogo.vue'
import { useViewerStore } from '@/entities/Viewer/store'

const viewerStore = useViewerStore()
const { viewer } = storeToRefs(viewerStore)

</script>

<template>
    <div class="left-sidebar" v-if="viewer">
        <div class="body">
            <left-sidebar-logo/>
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
    padding-right: 10px;
    width: 100%;
}

.body {
    display: flex;
    flex-direction: column;
    grid-gap: 10px;
}
</style>
