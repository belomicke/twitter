<script setup lang="ts">
import { PropType } from 'vue'
import { IconNames, XIcon } from '@/shared/ui/XIcon'

const props = defineProps({
    type: {
        type: String as PropType<'default' | 'primary' | 'info' | 'danger'>,
        required: false,
        default: 'default'
    },
    size: {
        type: String as PropType<'small' | 'default' | 'large' | 'extra-large'>,
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
    },
    iconSize: {
        type: Number,
        required: false,
        default: 24
    },
    iconIsFilled: {
        type: Boolean,
        required: false,
        default: false
    },
    textAlign: {
        type: String as PropType<'start' | 'center' | 'end'>,
        required: false,
        default: 'center'
    },
    noBorder: {
        type: Boolean,
        required: false,
        default: false
    },
    noPadding: {
        type: Boolean,
        required: false,
        default: false
    }
})

const emit = defineEmits(['click'])

function clickHandler(e: MouseEvent) {
    e.preventDefault()
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
            'danger': type === 'danger',

            'extra-large': size === 'extra-large',
            'large': size === 'large',
            'medium': size === 'default',
            'small': size === 'small',

            'text-start': textAlign === 'start',
            'text-end': textAlign === 'end',
            'no-border': noBorder,
            'no-padding': noPadding,

            'active': active,

            'is-round': rounded,
            'is-disabled': disabled,
            'bold': bold,
            'block': block,
            'is-circle': circle,
            'is-text': text
        }"
        v-bind="$attrs"
        @click="clickHandler"
    >
        <x-icon
            v-if="icon"
            :icon="icon"
            :size="iconSize"
            :filled="iconIsFilled"
        />
        <slot />
    </button>
</template>

<style scoped>
@import './styles/types.css';
@import './styles/sizes.css';
@import './styles/text.css';

.x-button {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    grid-gap: 10px;
    line-height: 1;
    height: 32px;
    white-space: nowrap;
    cursor: pointer;
    color: var(--x-button-text-color);
    text-align: center;
    box-sizing: border-box;
    outline: none;
    transition: color .15s, background-color .15s;
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
}

@media (hover: none) {
    .x-button:hover {
        color: var(--x-button-text-color);
        border-color: var(--x-button-border-color);
        background-color: var(--x-button-bg-color);
    }
}

.x-button:active,
.x-button:active:hover {
    color: var(--x-button-pressed-text-color);
    border-color: var(--x-button-pressed-border-color);
    background-color: var(--x-button-pressed-bg-color);
}

.x-button.active,
.x-button.active:hover {
    color: var(--x-button-pressed-text-color);
    border-color: var(--x-button-pressed-border-color);
    background-color: var(--x-button-pressed-bg-color);
}

.x-button.is-disabled,
.x-button.is-disabled:hover,
.x-button.is-disabled:focus {
    cursor: not-allowed;
    opacity: .8;
    color: var(--x-button-disabled-text-color);
    background-color: var(--x-button-disabled-bg-color);
    border-color: var(--x-button-disabled-border-color);
}

.x-button > svg {
    color: var(--x-button-text-color) !important;
    transition: color .15s;
}

.x-button.no-border {
    border: 0;
}

.x-button.no-padding {
    padding: 0 !important;
}

.x-button:hover {
    outline: none;
}

.x-button.is-text {
    --x-button-bg-color: transparent;
    border: 0;
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
    border-radius: 50%;
    padding: 0;
}

.x-button.text-start {
    justify-content: start;
}

.x-button.text-end {
    justify-content: end;
}
</style>
