<script setup lang="ts">
defineProps({
    path: {
        type: String,
        required: true
    }
})
</script>

<template>
    <div
        class="banner"
        :style="{
            'background-image': path ? `url(${path})` : ''
        }"
    />
</template>

<style scoped>
.banner {
    height: 200px;
    background-color: rgb(50, 50, 50);
}
</style>
