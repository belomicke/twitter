<script setup lang="ts">
import { PropType } from 'vue'
import { IconNames } from '@/shared/ui/XIcon'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import XCounter from '@/shared/ui/XCounter/XCounter.vue'

defineProps({
    icon: {
        type: String as PropType<IconNames>,
        required: true
    },
    color: {
        type: String,
        required: false,
        default: '113, 118, 123'
    },
    colorHover: {
        type: String,
        required: false,
        default: '113, 118, 123'
    },
    backgroundColor: {
        type: String,
        required: false,
        default: 'transparent'
    },
    backgroundColorHover: {
        type: String,
        required: false,
        default: '113, 118, 123'
    },
    backgroundOpacity: {
        type: String,
        required: false,
        default: '.2'
    },
    filled: {
        type: Boolean,
        required: false,
        default: false
    },
    active: {
        type: Boolean,
        required: false,
        default: false
    },
    count: {
        type: Number,
        required: false,
        default: 0
    },
    size: {
        type: Number,
        required: false,
        default: 18
    },
    padding: {
        type: Number,
        required: false,
        default: 8
    },
    disable: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>

<template>
    <div
        class="x-icon-button"
        :class="{
            active,
            disable
        }"
        :style="{
            '--x-color': color,
            '--x-color-hover': colorHover,

            '--x-background-color': backgroundColor,
            '--x-background-color-hover': backgroundColorHover,

            '--x-background-opacity': backgroundOpacity,

            '--x-padding': `${padding}px`,
            '--x-icon-size': `${size}px`
        }"
        v-bind="$attrs"
    >
        <div class="icon">
            <x-icon
                :icon="icon"
                :filled="filled"
                :size="size"
            />
        </div>
        <x-counter
            v-if="count > 0"
            class="count"
            :count="count"
        />
    </div>
</template>

<style scoped>
.x-icon-button {
    --x-color: 113, 118, 123;
    --x-color-hover: 113, 118, 123;

    --x-background-color: transparent;
    --x-background-color-hover: 113, 118, 123;

    --x-background-opacity: .75;

    --x-padding: 8px;
    --x-icon-size: 18px;

    display: flex;
    justify-content: center;
    align-items: center;
    grid-gap: 5px;
    position: relative;
    cursor: pointer;
}

.x-icon-button svg {
    position: relative;
    z-index: 1;
    transition: color .15s;
}

.x-icon-button.disable {
    opacity: .7;
    pointer-events: none;
}

.icon {
    display: flex;
    position: relative;
    z-index: 100;
}

.icon::after {
    content: "";
    width: calc(var(--x-icon-size) + calc(var(--x-padding) * 2));
    height: calc(var(--x-icon-size) + calc(var(--x-padding) * 2));
    position: absolute;
    top: calc(0px - var(--x-padding));
    left: calc(0px - var(--x-padding));
    border-radius: 50%;
    z-index: 0;
    transition: background-color .15s;
}

.x-icon-button svg {
    color: rgb(var(--x-color)) !important;
}

.x-icon-button > .icon::after {
    background-color: rgb(var(--x-background-color), var(--x-background-opacity));
}

.x-icon-button .count {
    color: rgb(var(--x-color)) !important;
}

@media (hover: hover) {
    .x-icon-button:hover svg {
        color: rgb(var(--x-color-hover)) !important;
    }

    .x-icon-button:hover > .icon::after {
        background-color: rgba(var(--x-background-color-hover), var(--x-background-opacity));
    }

    .x-icon-button:hover .count {
        color: rgb(var(--x-color-hover)) !important;
    }
}

@media (hover: none) {
    .x-icon-button:active svg {
        color: rgb(var(--x-color-hover)) !important;
    }

    .x-icon-button:active > .icon::after {
        background-color: rgba(var(--x-background-color-hover), var(--x-background-opacity));
    }

    .x-icon-button:active .count {
        color: rgb(var(--x-color-hover)) !important;
    }
}
</style>
