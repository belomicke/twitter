<script setup lang="ts">
import XButton from '@/shared/ui/XButton/XButton.vue'

defineEmits(['close'])
</script>

<template>
    <div class="x-modal-header">
        <div class="button">
            <x-button
                icon="cross"
                size="large"
                @click="$emit('close')"
                circle
                text
            />
        </div>
        <div class="content">
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
.x-modal-header {
    display: flex;
    align-items: center;
    padding-left: 16px;
    padding-right: 16px;
    height: 53px;
    width: 100%;
    position: relative;
    border-bottom: 1px solid var(--x-border-color);
}

.button {
    position: absolute;
}

.content {
    width: 100%;
    margin-left: 40px;
}
</style>
