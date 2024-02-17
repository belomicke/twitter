<script setup lang="ts">
import {
    computed,
    onMounted,
} from 'vue'

import { useRoute } from 'vue-router'

import { useUserStore } from '@/entities/User/store'
import ProfileLayout from '@/pages/Profile/ProfileLayout/ProfileLayout.vue'

const route = useRoute()

const username = route.params.username as string

const store = useUserStore()

const user = computed(() => {
    return store.getUserByUsername(username)
})

onMounted(() => {
    store.fetchUser(username)
})

</script>

<template>
    <profile-layout
        v-if="user"
        :user="user"
    />
</template>
