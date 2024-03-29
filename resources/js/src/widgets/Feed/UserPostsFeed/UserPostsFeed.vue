<script setup lang="ts">
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import UserPostsEmptyFeed from '@/widgets/Feed/UserPostsFeed/UserPostsEmptyFeed.vue'
import { useFeedStore } from '@/entities/Feed/store'
import { useUserStore } from '@/entities/User/store'
import PostFeed from '@/entities/Feed/ui/PostFeed.vue'

const props = defineProps({
    username: {
        type: String,
        required: true
    }
})

const feedStore = useFeedStore()

const userStore = useUserStore()
const { getUserByUsername } = storeToRefs(userStore)

const user = computed(() => {
    return getUserByUsername.value(props.username)
})

function fetch() {
    if (!user.value) return

    if (user.value.posts_count) {
        feedStore.fetchUserPostsFeed(props.username)
    }
}
</script>

<template>
    <template v-if="user">
        <user-posts-empty-feed
            v-if="user.posts_count === 0"
            :username="username"
        />
        <post-feed
            v-else
            :id="`user:${username}:posts`"
            window
            @fetch="fetch"
        />
    </template>
</template>
