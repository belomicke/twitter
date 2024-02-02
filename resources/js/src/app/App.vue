<script setup lang="ts">
import { onMounted } from 'vue'
import '@/shared/ui/css/variables.css'
import '@/shared/ui/css/global.css'
import { useViewerStore } from '@/entities/Viewer/store'
import { storeToRefs } from 'pinia'
import LoadingPage from '@/pages/Loading/LoadingPage.vue'

const viewerStore = useViewerStore()

const { isLoading } = storeToRefs(viewerStore)

onMounted(() => {
    const mode = localStorage.getItem('mode') ?? 'light'
    const theme = localStorage.getItem('theme') ?? 'blue'

    document.body.classList.add(mode)
    document.body.classList.add(theme)

    viewerStore.fetchViewer()
})
</script>

<template>
    <loading-page
        v-if="isLoading"
    />
    <div
        class="container"
        v-else
    >
        <router-view/>
    </div>
</template>

<style scoped>
.container {
    min-height: 100vh;
    pointer-events: auto;
    width: 100%;
}
</style>
