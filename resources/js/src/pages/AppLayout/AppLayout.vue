<script setup lang="ts">
import LeftSidebar from '@/widgets/LeftSidebar/LeftSidebar.vue'
import RightSidebar from '@/widgets/RightSidebar/RightSidebar.vue'
</script>

<template>
    <div class="wrapper">
        <div class="container">
            <div class="sidebar-container">
                <div class="sidebar left">
                    <left-sidebar />
                </div>
            </div>
            <div class="page">
                <router-view />
            </div>
            <div class="sidebar-container">
                <div class="sidebar right">
                    <right-sidebar />
                </div>
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
    grid-template-columns: 300px minmax(0, 600px) 350px;
    grid-gap: 5px;
    width: 100%;
    max-width: calc(300px + 350px + 600px + 10px);
}

.sidebar-container {
    position: relative;
}

.sidebar {
    position: fixed;
}

.sidebar.left {
    width: 300px;
}

.sidebar.right {
    width: 350px;
}

.page {
    border-left: 1px solid var(--x-border-color);
    border-right: 1px solid var(--x-border-color);
    height: 100%;
}
</style>
