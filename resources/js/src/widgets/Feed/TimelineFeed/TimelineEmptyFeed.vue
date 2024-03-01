<script setup lang="ts">

import { computed } from 'vue'
import EmptyFeed from '@/entities/Feed/ui/EmptyFeed.vue'

const title = computed(() => {
    return 'Добро пожаловать!'
})

const subtitle = computed(() => {
    return 'Подпишитесь на интересующих вас людей и их посты будут отображаться здесь.'
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
