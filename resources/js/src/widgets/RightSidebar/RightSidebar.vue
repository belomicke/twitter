<script setup lang="ts">

import SidebarInput from '@/widgets/RightSidebar/ui/SidebarInput/SidebarInput.vue'
</script>

<template>
    <div class="right-sidebar">
        <sidebar-input />
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
