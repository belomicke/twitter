<script setup lang="ts">
import { PropType, ref } from 'vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

interface Option {
    value: number | string
    label: string
}

defineProps({
    label: {
        type: String,
        required: true,
    },
    options: {
        type: Array as PropType<Option[]>,
        required: true,
    },
})

const selectedOptionValue = ref<number>(0)

const select = ref<HTMLSelectElement | null>(null)

function containerClickHandler() {
    select.value?.click()
}
</script>

<template>
    <div
        class="x-select-container"
        @click="containerClickHandler"
    >
        <label class="label">
            <span>{{ label }}</span>
        </label>
        <select
            v-bind="$attrs"
            ref="select"
            class="select"
        >
            <option
                disabled
                :selected="selectedOptionValue === 0"
                class="option"
            />
            <option
                v-for="option in options"
                :key="option.value"
                class="option"
                :value="option.value"
                :selected="selectedOptionValue === option.value"
            >
                {{ option.label }}
            </option>
        </select>
        <div class="icon-container">
            <x-icon icon="chevron-down" />
        </div>
    </div>
</template>

<style scoped>
.x-select-container {
    display: flex;
    flex-grow: 1;
    border: 1px solid rgb(60, 60, 60);
    border-radius: var(--x-border-radius-base);
    position: relative;
    background-color: rgb(0, 0, 0);
    overflow: hidden;
}

.x-select-container:focus-within {
    border-color: var(--x-color-primary);
}

.label {
    position: absolute;
    font-weight: var(--x-font-weight-normal);
    line-height: 16px;
    pointer-events: none !important;
    font-size: 13px;
    word-wrap: break-word;
    padding-top: 8px;
    padding-left: 8px;
    padding-right: 8px;
    color: rgb(120, 120, 120);
}

.x-select-container:focus-within .label {
    color: var(--x-color-primary);
}

.select {
    font-size: 17px;
    color: rgb(231, 233, 234);
    background-color: rgba(0, 0, 0, 0.00);
    border: 0;
    outline: 0;
    line-height: 20px;
    margin-top: 16px;
    padding: 12px 8px 8px;
    width: 100%;
    appearance: none;
}

.option {
    background-color: rgb(0, 0, 0);
    line-height: 20px;
    cursor: pointer;
    font-size: 17px;
}

.icon-container {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: rgb(120, 120, 120);
    height: 1.5em;
    pointer-events: none !important;
}

.x-select-container:focus-within .icon-container {
    color: var(--x-color-primary);
}
</style>
