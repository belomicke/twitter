<script setup lang="ts">
import { computed } from "vue"
import { useFeedStore } from "@/entities/Feed/store"
import { storeToRefs } from "pinia"
import MediaPostsEmptyFeed from "@/widgets/Feed/MediaPostsFeed/MediaPostsEmptyFeed.vue"
import { useUserStore } from "@/entities/User/store"
import MediaPostFeed from "@/entities/Feed/ui/MediaPostFeed.vue"

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
    return getFeedById.value(`user:${props.username}:liked_posts`)
})

const user = computed(() => {
    return getUserByUsername.value(props.username)
})

function fetch() {
    if (!user.value) return

    if (user.value.media_posts_count) {
        feedStore.fetchUserMediaPostsFeed(props.username)
    }
}
</script>

<template>
    <template v-if="user">
        <media-posts-empty-feed
            v-if="user.media_posts_count === 0"
            :username="username"
        />
        <media-post-feed
            v-else
            :id="`user:${username}:media_posts`"
            window
            @fetch="fetch"
        />
    </template>
</template>

<style scoped>

</style>
