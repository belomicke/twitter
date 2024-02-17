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
            @click="$emit('click')"

            v-bind="$attrs"
        >
            {{ text }}
        </x-button>
    </div>
</template>

<style scoped>
.nav-item {
    height: 50px;
}
</style>
