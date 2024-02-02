<script setup lang="ts">

defineProps({
    path: {
        type: String,
        required: true
    },
    size: {
        type: Number,
        required: false,
        default: 132
    },
    rounded: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>

<template>
    <div
        class="user-avatar"
        :class="{
            'rounded': rounded,
        }"
        :style="{
            'background-image': `url(${path})`,
            'width': `${size}px`,
            'height': `${size}px`
        }"
    />
</template>

<style scoped>
.user-avatar {
    background-size: cover;
    background-position: center center;
}

.user-avatar.rounded {
    border-radius: 50%;
}
</style>
