<script setup lang="ts">
import { computed } from 'vue'

import UserPostsFeed from '@/widgets/Feed/UserPostsFeed.vue'
import { PropType } from 'vue/dist/vue'
import IUser from '@/shared/api/types/models/User'

const props = defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
})

const username = computed(() => {
    return String(props.user?.username)
})
</script>

<template>
    <user-posts-feed :username="username" />
</template>

<style scoped>

</style>
