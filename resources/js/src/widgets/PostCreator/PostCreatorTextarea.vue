<script setup lang="ts">
import { ref } from 'vue'
import XTextarea from '@/shared/ui/XTextarea/XTextarea.vue'

const { modelValue, maxLength } = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
        default: '',
    },
    maxLength: {
        type: Number,
        required: false,
        default: 0,
    },
})

const emit = defineEmits(['update:modelValue'])

const editor = ref<HTMLDivElement | null>(null)

function onInput(value: string) {
    emit('update:modelValue', value)
}
</script>

<template>
    <div class="textarea-container">
        <x-textarea
            class="textarea"
            maxlength="280"
            :model-value="modelValue"
            @update:model-value="onInput"
            no-wrapper
        />
        <div
            class="placeholder"
            :class="{
                'visible': modelValue.length === 0
            }"
            v-if="placeholder.length"
        >
            {{ placeholder }}
        </div>
    </div>
</template>

<style scoped>
.textarea-container {
    display: flex;
    position: relative;
    min-height: 96px;
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
