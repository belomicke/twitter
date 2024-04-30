<script setup lang="ts">

import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'

defineProps({
    right: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>

<template>
    <div
        class="post-creator-media-slide-button"
        :class="{ right }"
    >
        <x-icon-button
            icon="arrow-left"
            :size="17"

            color="255, 255, 255"
            color-hover="255, 255, 255"

            background-color="15, 20, 25"
            background-color-hover="63, 67, 71"

            background-opacity=".75"

            :padding="6"
        />
    </div>
</template>

<style scoped>
.post-creator-media-slide-button {
    pointer-events: all;
}

.post-creator-media-slide-button.right {
    transform: rotate(-180deg);
}
</style>
