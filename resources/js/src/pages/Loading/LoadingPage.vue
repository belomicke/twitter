<script setup lang="ts">

import XIcon from '@/shared/ui/XIcon/XIcon.vue'
</script>

<template>
    <div class="loading-page-container">
        <x-icon
            icon="logo"
            :size="512"
            color="rgb(255, 255, 255)"
        />
    </div>
</template>

<style scoped>
.loading-page-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100vw;
    height: 100vh;
}
</style>
