<script setup lang="ts">

import XIcon from '@/shared/ui/XIcon/XIcon.vue'

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
})

const emit = defineEmits(['update:modelValue'])

function inputHandler(value: string) {
    emit('update:modelValue', value)
}

</script>

<template>
    <div class="x-search-input">
        <div class="icon">
            <x-icon icon="search" />
        </div>
        <input
            ref="input"
            :value="modelValue"
            placeholder="Поиск"
            class="input"
            v-bind="$attrs"
            @input="inputHandler(($event.target as HTMLInputElement).value)"
        >
        <div
            class="icon right"
            :class="{
                visible: modelValue.length !== 0
            }"
            @click="inputHandler('')"
        >
            <x-icon icon="cross" />
        </div>
    </div>
</template>

<style scoped>
.x-search-input {
    display: flex;
    align-items: center;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
    width: 100%;
    background-color: var(--x-bg-color-page);
    border: 1px solid var(--x-border-color);
    transition: border-color .15s;
}

.x-search-input:focus-within {
    border-color: var(--x-color-primary);
}

.icon {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    padding-left: 10px;
    transition: color .15s;
}

.icon.right {
    border-radius: 50%;
    padding: 5px;
    margin-right: 10px;
    cursor: pointer;
    transform: scale(0);
    transition: background-color .15s, transform .15s;
}

.icon.right.visible {
    transform: scale(1);
}

.icon.right:hover {
    background-color: rgba(255, 255, 255, .1);
}

.icon svg {
    color: rgb(113, 118, 123) !important;
    transition: color .15s;
}

.x-search-input:focus-within svg {
    color: var(--x-color-primary) !important;
}

.input {
    outline: none;
    border: 0;
    padding: 10px;
    width: 100%;
    color: rgb(231, 233, 234);
    line-height: 20px;
    font-size: 15px;
    font-weight: 400;
    background-color: transparent;
}

</style>
