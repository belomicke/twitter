<script setup lang="ts">
import { PropType } from "vue"
import MediaPostsFeed from "@/widgets/Feed/MediaPostsFeed/MediaPostsFeed.vue"
import IUser from "@/shared/api/types/models/User"

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})
</script>

<template>
    <media-posts-feed :username="user.username" />
</template>
