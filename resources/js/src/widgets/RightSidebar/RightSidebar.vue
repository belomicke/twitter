<script setup lang="ts">

import GlobalFinder from '@/widgets/GlobalFinder/GlobalFinder.vue'
</script>

<template>
    <div class="right-sidebar">
        <global-finder />
    </div>
</template>

<style scoped>
.right-sidebar {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 6px 0;
    width: 100%;
}
</style>
