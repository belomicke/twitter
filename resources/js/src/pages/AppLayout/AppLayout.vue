<script setup lang="ts">
import LeftSidebar from '@/widgets/LeftSidebar/LeftSidebar.vue'
import RightSidebar from '@/widgets/RightSidebar/RightSidebar.vue'
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const searchPageIsCurrent = computed(() => {
    return route.path === '/search'
})
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
                    <right-sidebar v-if="!searchPageIsCurrent" />
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
    grid-template-columns: 300px minmax(300px, 600px) 350px;
    justify-content: center;
    width: 100%;
    max-width: calc(300px + 350px + 600px + 10px);
}

.sidebar-container {
    position: relative;
}

.sidebar {
    position: sticky;
    top: 0;
    padding: 0 5px;
    z-index: 100;
}

.sidebar.left {
    max-width: 300px;
    width: 100%;
}

.sidebar.right {
    max-width: 350px;
    width: 100%;
}

.page {
    border-left: 1px solid var(--x-border-color);
    border-right: 1px solid var(--x-border-color);
    height: 100%;
}

@media (max-width: 1280px) {
    .container {
        grid-template-columns: 60px minmax(300px, 600px) 350px;
        justify-content: center;
    }
}

@media (max-width: 1080px) {
    .container {
        grid-template-columns: 60px minmax(300px, 600px) 300px;
    }

    .sidebar.right {
        max-width: 300px;
    }
}

@media (max-width: 1000px) {
    .container {
        grid-template-columns: 60px minmax(300px, 600px);
        justify-content: center;
    }

    .sidebar.right {
        display: none;
    }
}

@media (max-width: 660px) {
    .page {
        border-right: none;
    }
}
</style>
