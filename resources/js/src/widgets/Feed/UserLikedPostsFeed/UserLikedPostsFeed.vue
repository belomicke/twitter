<script setup lang="ts">
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import UserLikedPostsEmptyFeed from './UserLikedPostsEmptyFeed.vue'
import { useFeedStore } from '@/entities/Feed/store'
import PostFeed from '@/entities/Feed/ui/PostFeed.vue'
import { useUserStore } from '@/entities/User/store'

const props = defineProps({
    username: {
        type: String,
        required: true
    }
})

const feedStore = useFeedStore()
const { getFeedById } = storeToRefs(feedStore)

const userStore = useUserStore()
const { getUserByUsername } = storeToRefs(userStore)

const feed = computed(() => {
    return getFeedById.value(`user:${props.username}:favorited_posts`)
})

const user = computed(() => {
    return getUserByUsername.value(props.username)
})

function fetch() {
    if (!user.value) return

    if (user.value.favourites_count) {
        feedStore.fetchUserLikedPostsFeed(props.username)
    }
}
</script>

<template>
    <template v-if="user">
        <user-liked-posts-empty-feed
            v-if="user.favourites_count === 0 && !feed"
            :username="username"
        />
        <post-feed
            v-else
            :id="`user:${username}:favorited_posts`"
            window
            @fetch="fetch"
        />
    </template>
</template>

<style scoped>

</style>
