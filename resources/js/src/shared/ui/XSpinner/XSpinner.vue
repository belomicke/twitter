<script setup lang="ts">
import Spinner from '@/shared/ui/svg/Spinner.vue'

defineProps({
    size: {
        type: Number,
        required: false,
        default: 26
    }
})
</script>

<template>
    <div
        class="x-spinner"
        :style="{
            'width': `${size}px`,
            'height': `${size}px`
        }"
    >
        <spinner/>
    </div>
</template>

<style scoped>
@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.x-spinner {
    animation-name: spin;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
    animation-duration: 0.75s;
}
</style>
