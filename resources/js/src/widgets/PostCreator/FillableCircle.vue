<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({
    value: {
        type: Number,
        required: true,
    },
    maxValue: {
        type: Number,
        required: true,
    },
})

const dashArray = computed(() => {
    if (props.value >= props.maxValue - 20) {
        return 94.24777960769379
    } else {
        return 62.83185307179586
    }
})

const size = computed(() => {
    if (props.value >= props.maxValue - 20) {
        return 30
    } else {
        return 20
    }
})

const color = computed(() => {
    if (props.value < props.maxValue - 20) {
        return 'var(--x-color-primary)'
    } else if (props.value >= props.maxValue - 20 && props.value < props.maxValue) {
        return 'var(--x-color-warning)'
    } else {
        return 'var(--x-color-danger)'
    }
})
</script>

<template>
    <div class="fillable-circle">
        <svg
            width="100%"
            height="100%"
            :viewBox="`0 0 ${size} ${size}`"
            class="circle"
            :class="{
                'big': size === 30
            }"
            style="overflow: visible;"
        >
            <defs>
                <clipPath id="0.3519973884749943">
                    <rect
                        height="100%"
                        width="0"
                        x="0"
                    />
                </clipPath>
            </defs>
            <circle
                cx="50%"
                cy="50%"
                fill="none"
                :r="size / 2"
                stroke="#2F3336"
                stroke-width="2"
            />
            <circle
                cx="50%"
                cy="50%"
                fill="none"
                :r="size / 2"
                :stroke="color"
                :stroke-dasharray="dashArray"
                :stroke-dashoffset="dashArray - dashArray / maxValue * value"
                :data-value="value"
                stroke-linecap="round"
                stroke-width="2"
            />
            <circle
                cx="50%"
                cy="50%"
                clip-path="url(#0.3519973884749943)"
                :stroke="color"
                r="0"
            />
        </svg>
        <div
            class="count"
            :class="{
                'visible': value >= maxValue - 20
            }"
            :style="{
                'color': color
            }"
        >
            {{ maxValue - value }}
        </div>
    </div>
</template>

<style scoped>
.fillable-circle {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 30px;
    position: relative;
}

.circle {
    width: 20px;
    height: 20px;
    transform-origin: center center;
    transform: rotate(-90deg);
    transition: transform .15s;
}

.circle > * {
    transition: stroke .15s;
}

.circle.big {
    transform: scale(1.5) rotate(-90deg);
}

.count {
    font-size: 13px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity .15s, color .15s;
}

.count.visible {
    opacity: 1;
}
</style>
