<script setup lang="ts">
import { PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
})
</script>

<template>
    <div class="user-stats">
        <div class="user-stat">
            <span class="user-stat-value">{{ user.follows_count }}</span>
            <span class="user-stat-text"> в читаемых</span>
        </div>
        <div class="user-stat">
            <span class="user-stat-value">{{ user.followers_count }}</span>
            <span class="user-stat-text"> читателей</span>
        </div>
    </div>
</template>

<style scoped>
.user-stats {
    display: flex;
    grid-gap: 15px;
}

.user-stat {
    white-space: pre;
    line-height: 16px;
    font-size: 14px;
    word-wrap: break-word;
}

.user-stat-value {
    color: rgb(231, 233, 234);
    font-weight: var(--x-font-weight-bold);
}

.user-stat-text {
    color: rgb(113, 118, 123);
}
</style>
