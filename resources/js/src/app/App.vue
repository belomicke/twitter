<script setup lang="ts">
import { onMounted } from 'vue'
import { storeToRefs } from 'pinia'
import LoadingPage from '@/pages/Loading/LoadingPage.vue'
import { useViewerStore } from '@/entities/Viewer/store'
import '@/shared/ui/css/variables.css'
import '@/shared/ui/css/global.css'
import AppNotifications from '@/pages/AppLayout/ui/AppNotifications/AppNotifications.vue'

const viewerStore = useViewerStore()

const { isLoading } = storeToRefs(viewerStore)

onMounted(() => {
    const mode = localStorage.getItem('mode')
    const theme = localStorage.getItem('theme')

    if (!mode || !['light', 'dark'].includes(mode)) {
        localStorage.setItem('mode', 'dark')
        document.body.classList.add('dark')
    } else {
        document.body.classList.add(mode)
    }

    if (!theme || !['blue', 'purple'].includes(theme)) {
        localStorage.setItem('theme', 'blue')
        document.body.classList.add('blue')
    } else {
        document.body.classList.add(theme)
    }

    viewerStore.fetchViewer()
})
</script>

<template>
    <loading-page
        v-if="isLoading"
    />
    <div
        v-else
        class="container"
    >
        <router-view />
        <Teleport to="#portals">
            <app-notifications />
        </Teleport>
    </div>
</template>

<style scoped>
.container {
    min-height: 100vh;
    pointer-events: auto;
    width: 100%;
}
</style>
