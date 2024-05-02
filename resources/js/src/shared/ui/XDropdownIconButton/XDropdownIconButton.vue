<script setup lang="ts">

import { computed, PropType, ref } from 'vue'
import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'
import XDropdown from '@/shared/ui/XDropdown/XDropdown.vue'
import { IconNames } from '@/shared/ui/XIcon'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

export interface XDropdownIconButtonOption {
    icon: IconNames
    label: string
    action: () => void
    style?: string
}

const props = defineProps({
    icon: {
        type: String as PropType<IconNames>,
        required: true
    },
    size: {
        type: Number,
        required: false,
        default: 18
    },
    count: {
        type: Number,
        required: false,
        default: 0
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
    options: {
        type: Array as PropType<XDropdownIconButtonOption[]>,
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
        default: 'var(--x-color-primary-code)'
    },

    backgroundColor: {
        type: String,
        required: false,
        default: '113, 118, 123'
    },
    backgroundColorHover: {
        type: String,
        required: false,
        default: 'var(--x-color-primary-code)'
    }
})

const dropdownIsOpen = ref<boolean>(false)

const isActive = computed(() => {
    return props.active ? props.active : dropdownIsOpen.value
})
</script>

<template>
    <x-dropdown
        v-model="dropdownIsOpen"
        x-side="left"
        y-side="top"
    >
        <template #default>
            <x-icon-button
                :icon="icon"
                :size="size"
                :count="count"
                :filled="filled"

                :active="isActive"

                :color="dropdownIsOpen ? colorHover : color"
                :color-hover="colorHover"

                :background-color="dropdownIsOpen ? backgroundColorHover : backgroundColor"
                :background-color-hover="backgroundColorHover"
            />
        </template>
        <template #dropdown>
            <div
                v-if="options.length"
                class="options"
            >
                <div
                    v-for="option in options"
                    :key="option.label"
                    class="option"
                    :style="option.style"
                    @click="option.action"
                >
                    <x-icon
                        class="option-icon"
                        :icon="option.icon"
                        color="inherit"
                    />
                    <span class="option-label">
                        {{ option.label }}
                    </span>
                </div>
            </div>
        </template>
    </x-dropdown>
</template>

<style scoped>
.options {
    display: flex;
    flex-direction: column;
    min-width: 200px;
    border-radius: 15px;
    padding: 5px 0;
}

.option {
    display: flex;
    align-items: center;
    margin: .125rem .25rem;
    padding: 5px 10px;
    border-radius: .375rem;
    cursor: pointer;
}

.option:hover {
    background: rgb(0, 0, 0, .4);
}

.option-icon {
    max-width: 1.25rem;
    font-size: 1.25rem;
    margin-right: 15px;
}

.option-label {
    font-size: 14px;
    font-weight: 600;
}
</style>
