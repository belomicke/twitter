<script setup lang="ts">

import { ref } from 'vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

defineExpose({
    startLoading,
    stopLoading
})

const emit = defineEmits(['click'])

function clickHandler(e: MouseEvent) {
    e.stopPropagation()
    emit('click', e)
}

const isLoading = ref<boolean>(false)

function startLoading() {
    isLoading.value = true
}

function stopLoading() {
    isLoading.value = false
}
</script>

<template>
    <div class="load-more">
        <div
            v-if="isLoading"
            class="load-more-loader"
        >
            <x-icon
                icon="loader"
                :size="40"
                color="var(--x-color-primary)"
            />
        </div>
        <div
            v-else
            class="load-more-button"
            @click="clickHandler"
        >
            <div class="load-more-icon">
                <div class="load-more-icon-dot" />
                <div class="load-more-icon-dot" />
                <div class="load-more-icon-dot" />
            </div>
            <div class="load-more-text">
                Показать ответы
            </div>
        </div>
    </div>
</template>

<style scoped>
.load-more {
    display: flex;
    justify-content: center;
}

.load-more-button {
    display: grid;
    grid-template-columns: 40px 1fr;
    grid-gap: 10px;
    padding: 0 15px;
    width: 100%;
    cursor: pointer;
    transition: background-color .15s;
}

.load-more-button:hover {
    background-color: rgba(255, 255, 255, 0.03);
}

.load-more-loader {
    width: 40px;
    height: 40px;
}

.load-more-icon {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    height: 15px;
    margin: auto 0;
}

.load-more-icon-dot {
    width: 2px;
    height: 2px;
    background-color: var(--x-border-color);
}

.load-more-text {
    color: var(--x-color-primary);
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    padding: 10px 0;
}
</style>
