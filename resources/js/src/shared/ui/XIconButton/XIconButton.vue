<script setup lang="ts">
import { PropType } from 'vue'
import { IconNames } from '@/shared/ui/XIcon'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import XCounter from '@/shared/ui/XCounter/XCounter.vue'

defineProps({
    icon: {
        type: String as PropType<IconNames>,
        required: true,
    },
    color: {
        type: String,
        required: true,
    },
    filled: {
        type: Boolean,
        required: false,
        default: false,
    },
    active: {
        type: Boolean,
        required: false,
        default: false,
    },
    count: {
        type: Number,
        required: false,
        default: 0,
    },
})
</script>

<template>
    <div
        class="x-icon-button"
        :class="{
            active
        }"
        :style="{ '--x-action-color': color }"
        v-bind="$attrs"
    >
        <div class="icon">
            <x-icon
                :icon="icon"
                :filled="filled"
                :size="18"
            />
        </div>
        <x-counter
            v-if="count > 0"
            :count="count"
        />
    </div>
</template>

<style scoped>
.x-icon-button {
    --x-action-color: 113, 118, 123;

    display: flex;
    justify-content: center;
    align-items: center;
    grid-gap: 5px;
    position: relative;
}

.icon {
    display: flex;
    position: relative;
    height: 18px;
    width: 18px;
    z-index: 100;
}

.icon::after {
    content: "";
    width: 34px;
    height: 34px;
    position: absolute;
    top: -8px;
    left: -8px;
    border-radius: 50%;
    transition: background-color .15s;
}

.x-icon-button svg {
    color: rgb(113, 118, 123) !important;
    transition: color .15s;
}

.x-icon-button:hover > .icon::after,
.x-icon-button:active > .icon::after {
    background-color: rgba(var(--x-action-color), .2);
}

.x-icon-button.active svg {
    color: rgb(var(--x-action-color)) !important;
}


.x-icon-button:hover svg {
    color: rgb(var(--x-action-color)) !important;
}

.x-icon-button:hover .count,
.x-icon-button.active .count {
    color: rgb(var(--x-action-color)) !important;
}

@media (hover: none) {
    .x-icon-button:hover > .icon::after {
        background-color: transparent;
    }

    .x-icon-button:active > .icon::after {
        background-color: rgba(var(--x-action-color), .2);
    }

    .x-icon-button.active svg {
        color: rgb(var(--x-action-color)) !important;
    }

    .x-icon-button:hover svg {
        background-color: transparent;
    }

    .x-icon-button:active svg {
        color: rgb(var(--x-action-color)) !important;
    }

    .x-icon-button:hover .count,
    .x-icon-button.active .count {
        color: rgb(var(--x-action-color)) !important;
    }
}
</style>
