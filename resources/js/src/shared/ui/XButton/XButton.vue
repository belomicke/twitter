<script setup lang="ts">
import { PropType } from 'vue'
import { IconNames, XIcon } from '@/shared/ui/XIcon'

const props = defineProps({
    type: {
        type: String as PropType<'default' | 'primary' | 'info'>,
        required: false,
        default: 'default'
    },
    size: {
        type: String as PropType<'small' | 'default' | 'large'>,
        required: false,
        default: 'default'
    },
    rounded: {
        type: Boolean,
        required: false,
        default: false
    },
    active: {
        type: Boolean,
        required: false,
        default: false
    },
    disabled: {
        type: Boolean,
        required: false,
        default: false
    },
    bold: {
        type: Boolean,
        required: false,
        default: false
    },
    block: {
        type: Boolean,
        required: false,
        default: false
    },
    circle: {
        type: Boolean,
        required: false,
        default: false
    },
    text: {
        type: Boolean,
        required: false,
        default: false
    },
    icon: {
        type: String as PropType<IconNames>,
        required: false,
        default: ''
    }
})

const emit = defineEmits(['click'])

function clickHandler() {
    if (props.disabled) return

    emit('click')
}
</script>

<template>
    <button
        class="x-button"
        :class="{
            'default': type === 'default',
            'primary': type === 'primary',
            'info': type === 'info',

            'large': size === 'large',
            'small': size === 'small',

            'is-round': rounded,
            'is-disabled': disabled,
            'bold': bold,
            'is-active': active,
            'block': block,
            'is-circle': circle,
            'is-text': text
        }"
        @click="clickHandler"
        v-bind="$attrs"
    >
        <x-icon
            :icon="icon"
            v-if="icon"
        />
        <slot></slot>
    </button>
</template>

<style scoped>
@import './styles/types.css';
@import './styles/sizes.css';

.x-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    line-height: 1;
    height: 32px;
    white-space: nowrap;
    cursor: pointer;
    color: var(--x-button-text-color);
    text-align: center;
    box-sizing: border-box;
    outline: none;
    transition: .15s;
    font-weight: var(--x-button-font-weight);
    user-select: none;
    vertical-align: middle;
    background-color: var(--x-button-bg-color);
    border: var(--x-border);
    border-color: var(--x-button-border-color);
    padding: 8px 15px;
    font-size: var(--x-font-size-base);
    border-radius: var(--x-border-radius-base);
}

.x-button:hover {
    color: var(--x-button-hover-text-color);
    border-color: var(--x-button-hover-border-color);
    background-color: var(--x-button-hover-bg-color);
    outline: none;
}

.x-button:active, .x-button.is-active {
    color: var(--x-button-active-text-color);
    border-color: var(--x-button-active-border-color);
    background-color: var(--x-button-active-bg-color);
    outline: none;
}

.x-button.is-disabled,
.x-button.is-disabled:hover,
.x-button.is-disabled:focus {
    color: var(--x-button-disabled-text-color);
    cursor: not-allowed;
    background-image: none;
    background-color: var(--x-button-disabled-bg-color);
    border-color: var(--x-button-disabled-border-color);
}

.x-button.block {
    width: 100%;
}

.x-button.bold {
    font-weight: var(--x-font-weight-bold);
}

.x-button.is-round {
    border-radius: var(--x-border-radius-round);
}

.x-button.is-circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    padding: 8px;
}

.x-button.is-text {
    color: var(--x-button-text-color);
    border: 0 solid transparent;
    background-color: transparent;
}

.x-button.is-text:not(.is-disabled):hover {
    background-color: var(--x-fill-color-light);
}

.x-button.is-text:not(.is-disabled):active {
    background-color: var(--x-fill-color-lighter);
}
</style>
