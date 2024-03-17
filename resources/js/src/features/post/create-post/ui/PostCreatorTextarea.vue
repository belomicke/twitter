<script setup lang="ts">
import { POST_TEXT_MAX_LENGTH } from '../config'
import XTextarea from '@/shared/ui/XTextarea/XTextarea.vue'

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
        default: '',
    },
    height: {
        type: Number,
        required: false,
        default: 68,
    },
})

const emit = defineEmits(['update:modelValue'])

function onInput(value: string) {
    emit('update:modelValue', value)
}
</script>

<template>
    <div
        class="textarea-container"
        :style="{ 'min-height': `${height}px` }"
    >
        <x-textarea
            class="textarea"
            :maxlength="POST_TEXT_MAX_LENGTH"
            :model-value="modelValue"
            no-wrapper
            @update:model-value="onInput"
        />
        <div
            v-if="placeholder.length"
            class="placeholder"
            :class="{
                'visible': modelValue.length === 0
            }"
        >
            {{ placeholder }}
        </div>
    </div>
</template>

<style scoped>
.textarea-container {
    display: flex;
    position: relative;
    min-height: 68px;
    max-height: 720px;
}

.textarea {
    padding: 0;
    border: 0;
    width: 100%;
    outline: 0;
    text-align: left;
    resize: none;
    color: inherit;
    background-color: rgba(0, 0, 0, 0);
    font-size: 20px;
    line-height: 24px;
    -webkit-user-modify: read-write-plaintext-only;
}

.placeholder {
    position: absolute;
    top: 0;
    left: 15px;
    opacity: 0;
    font-size: 20px;
    line-height: 24px;
    color: rgb(100, 100, 100);
    pointer-events: none;
    transition: opacity .15s, left .15s;
}

.placeholder.visible {
    left: 0;
    opacity: 1;
}
</style>
