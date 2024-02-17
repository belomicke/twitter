<script setup lang="ts">
import { computed } from 'vue'

import { useRoute } from 'vue-router'

import UserPostsFeed from '@/widgets/Feed/UserPostsFeed.vue'

const route = useRoute()

const username = computed(() => {
    return String(route.params.username)
})
</script>

<template>
    <user-posts-feed :username="username" />
</template>

<style scoped>

</style>
