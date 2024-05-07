<script setup lang="ts">

import { computed } from 'vue'
import EmptyFeed from '@/entities/Feed/ui/EmptyFeed.vue'

const title = computed(() => {
    return 'Сохраняйте посты на потом'
})

const subtitle = computed(() => {
    return 'Добавляйте посты в закладки, чтобы без труда возвращаться к ним в будущем.'
})

</script>

<template>
    <empty-feed
        :title="title"
        :subtitle="subtitle"
    />
</template>

<style scoped>

</style>
