<script setup lang="ts">
import { computed } from "vue"
import { storeToRefs } from "pinia"
import { useFeedStore } from "@/entities/Feed/store"
import { useUserStore } from "@/entities/User/store"
import PostFeed from "@/entities/Feed/ui/PostFeed.vue"
import UserFavoritePostsEmptyFeed from "@/widgets/Feed/UserFavoritedPostsFeed/UserFavoritePostsEmptyFeed.vue"

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

    if (user.value.favorite_posts_count) {
        feedStore.fetchUserFavoritePostsFeed(props.username)
    }
}
</script>

<template>
    <template v-if="user">
        <user-favorite-posts-empty-feed
            v-if="user.favorite_posts_count === 0"
            :username="username"
        />
        <post-feed
            v-else
            :id="`user:${username}:favorite_posts`"
            window
            with-pinned-post
            @fetch="fetch"
        />
    </template>
</template>

<style scoped>

</style>
