<script setup lang="ts">
import { useRoute } from 'vue-router'
import { useUserStore } from '@/entities/User/store'
import { computed, onMounted } from 'vue'
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
        :user="user"
        v-if="user"
    />
</template>
