<script setup lang="ts">
import { computed } from 'vue'

import {
    useRoute,
    useRouter,
} from 'vue-router'

import XTabs from '@/shared/ui/XTabs/XTabs.vue'

const router = useRouter()
const route = useRoute()

const username = computed(() => {
    return String(route.params.username)
})

const tabs = computed(() => {
    return [
        {
            text: "Посты",
            active: route.fullPath === `/profile/${username.value}`,
            onClick: () => router.push(`/profile/${username.value}`)
        }
    ]
})
</script>

<template>
    <x-tabs :tabs="tabs" />
</template>

<style scoped>
</style>
