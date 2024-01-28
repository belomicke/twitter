<script setup lang="ts">
import { onMounted } from 'vue'
import '@/shared/ui/css/variables.css'
import '@/shared/ui/css/global.css'

onMounted(() => {
    const theme = localStorage.getItem('theme') ?? 'light'

    document.body.classList.add(theme)
})
</script>

<template>
    <div class="container">
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
