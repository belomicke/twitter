<script setup lang="ts">
defineProps({
    color: {
        type: String,
        required: false,
        default: 'rgb(255, 255, 255)',
    },
})
</script>

<template>
    <svg
        class="animation"
        viewBox="0 0 100 100"
    >
        <circle
            cx="50"
            cy="50"
            fill="none"
            stroke="currentColor"
            stroke-width="5"
            r="30"
            stroke-dasharray="141.37166941154067 49.12388980384689"
            transform="matrix(1,0,0,1,0,0)"
        />
    </svg>
</template>

<style scoped>
@keyframes rotate {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}

.animation {
    animation: rotate 1s linear infinite;
}
</style>
