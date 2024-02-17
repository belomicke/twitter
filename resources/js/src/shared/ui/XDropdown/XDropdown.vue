<script setup lang="ts">
import { onMounted, onUnmounted, ref } from 'vue'

const container = ref<HTMLDivElement | null>(null)
const dropdownIsOpen = ref<boolean>(false)

onMounted(() => {
    window.addEventListener('click', close)
})

onUnmounted(() => {
    window.removeEventListener('click', close)
})

function close(e: MouseEvent) {
    const target = e.target as Element

    if (!container.value?.contains(target)) {
        dropdownIsOpen.value = false
    }
}
</script>

<template>
    <div class="x-dropdown-container" ref="container">
        <div @click="dropdownIsOpen = true">
            <slot></slot>
        </div>
        <div
            class="x-dropdown"
            :class="{
                'visible': dropdownIsOpen
            }"
        >
            <slot name="dropdown"></slot>
        </div>
    </div>
</template>

<style scoped>
.x-dropdown-container {
    position: relative;
}

.x-dropdown {
    position: absolute;
    top: 0;
    width: 100%;
    border-radius: 10px;
    box-shadow: rgba(255, 255, 255, 0.2) 0 0 15px, rgba(255, 255, 255, 0.15) 0 0 3px 1px;
    overflow: hidden;
    transform: scale(.85) translateY(calc(-100% - 10px));
    opacity: 0;
    transition: transform .15s, opacity .15s;
    pointer-events: none;
}

.x-dropdown.visible {
    pointer-events: auto;
    opacity: 1;
    transform: scale(1) translateY(calc(-100% - 10px));
}
</style>
