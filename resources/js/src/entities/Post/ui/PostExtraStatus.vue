<script setup lang="ts">

import { PropType } from 'vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import { IconNames } from '@/shared/ui/XIcon'

defineProps({
    icon: {
        type: String as PropType<IconNames>,
        required: true,
    },
    text: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <div class="extra-status">
        <div class="icon">
            <x-icon
                :icon="icon"
                :size="16"
                color="rgb(113, 118, 123)"
            />
        </div>
        <div class="text">
            {{ text }}
        </div>
    </div>
</template>

<style scoped>
.extra-status {
    display: grid;
    grid-template-columns: 40px 1fr;
    grid-gap: 10px;
    padding: 5px 15px 0;
}

.icon {
    display: flex;
    justify-content: end;
    align-items: center;
    color: rgb(113, 118, 123) !important;
}

.text {
    color: rgb(113, 118, 123);
    line-height: 16px;
    font-size: 13px;
    font-weight: 700;
}
</style>
