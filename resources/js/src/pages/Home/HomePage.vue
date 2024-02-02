<script setup lang="ts">
import LeftSidebar from '@/widgets/LeftSidebar/LeftSidebar.vue'
</script>

<template>
    <div class="wrapper">
        <div class="container">
            <div class="sidebar-container">
                <div class="sidebar">
                    <LeftSidebar/>
                </div>
            </div>
            <div class="page">
                <router-view/>
            </div>
            <div class="sidebar-container">
                <div class="sidebar"></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    display: flex;
    justify-content: center;
    height: 100vh;
    overflow-y: scroll;
}

.container {
    display: grid;
    grid-template-columns: 300px 1fr 300px;
    width: 100%;
    max-width: 1280px;
}

.sidebar-container {
    position: relative;
}

.sidebar {
    position: fixed;
    width: 300px;
}

.page {
    border-left: 1px solid var(--x-border-color);
    border-right: 1px solid var(--x-border-color);
    height: 100%;
}
</style>
