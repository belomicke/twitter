<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { storeToRefs } from 'pinia'


import { useUserStore } from '@/entities/User/store'
import ProfileLayout from '@/pages/Profile/ProfileLayout/ProfileLayout.vue'

const route = useRoute()

const store = useUserStore()
const { getUserByUsername } = storeToRefs(store)

const user = computed(() => {
    return getUserByUsername.value(route.params.username as string)
})

watch(route, (newValue) => {
    store.fetchUser(newValue.params.username as string)
})

onMounted(() => {
    store.fetchUser(route.params.username as string)
})
</script>

<template>
    <profile-layout
        v-if="user"
        :user="user"
    >
        <router-view :user="user" />
    </profile-layout>
</template>
