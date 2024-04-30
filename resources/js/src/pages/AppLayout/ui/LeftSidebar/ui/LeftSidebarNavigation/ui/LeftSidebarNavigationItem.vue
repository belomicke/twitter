<script setup lang="ts">

import { PropType } from 'vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import { IconNames } from '@/shared/ui/XIcon'

defineProps({
    text: {
        type: String,
        required: true
    },
    icon: {
        type: String as PropType<IconNames>,
        required: true
    },
    active: {
        type: Boolean,
        required: true
    }
})

defineEmits(['click'])
</script>

<template>
    <div class="nav-item">
        <x-button
            class="button"
            type="primary"
            size="extra-large"
            text
            text-align="start"
            block
            :class="{
                'active': active
            }"
            :active="active"

            :icon="icon"
            :icon-size="26"
            :icon-is-filled="active"
            v-bind="$attrs"

            @click="$emit('click')"
        >
            <span class="text">{{ text }}</span>
        </x-button>
    </div>
</template>

<style scoped>
.nav-item {
    height: 50px;
}

@media (max-width: 1280px) {
    .button {
        width: 50px !important;
        padding: 12px !important;
        border-radius: 50%;
    }

    .text {
        display: none;
    }
}
</style>
