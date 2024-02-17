<script setup lang="ts">
import { PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    },
    fontSize: {
        type: Number as PropType<15 | 20>,
        required: false,
        default: 15
    }
})
</script>

<template>
    <div
        class="name"
        :style="{
            'font-size': `${fontSize}px`,
            'line-height': `${fontSize === 20 ? 24 : 20}px`
        }"
    >
        {{ user.name }}
    </div>
</template>

<style scoped>
.name {
    color: rgb(231, 233, 234);
    line-height: 20px;
    font-weight: var(--x-font-weight-bold);
    word-wrap: break-word;
    white-space: nowrap;
}
</style>
