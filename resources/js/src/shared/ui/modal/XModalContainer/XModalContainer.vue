<script setup lang="ts">
import XModalHeader from '@/shared/ui/modal/XModalHeader.vue'
import XSpinner from '@/shared/ui/XSpinner/XSpinner.vue'

defineProps({
    loading: {
        type: Boolean,
        required: false,
        default: false
    }
})

defineEmits(['close'])
</script>

<template>
    <div class="x-modal-wrapper">
        <div class="x-modal-container">
            <div class="spinner-container" v-if="loading">
                <x-spinner/>
            </div>
            <div class="x-modal" v-else>
                <x-modal-header @close="$emit('close')">
                    <slot name="header"></slot>
                </x-modal-header>
                <div class="content">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.x-modal-wrapper {
    display: flex;
    overflow-x: hidden;
    overflow-y: hidden;
    max-width: 90vw;
    flex-shrink: 1;
    height: 650px;
    max-height: 90vh;
    min-height: 400px;
    min-width: 600px;
    border-radius: 16px;
    background-color: rgb(0, 0, 0);
    position: relative;
}

.x-modal-container {
    display: flex;
    flex-shrink: 1;
    flex-grow: 1;
    background-color: rgb(0, 0, 0);
    max-width: 600px;
}

.spinner-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
}

.x-modal {
    width: 100%;
}

.content {
    display: flex;
    flex-grow: 1;
    flex-shrink: 1;
    flex-direction: column;
    height: calc(100% - 53px);
}
</style>
