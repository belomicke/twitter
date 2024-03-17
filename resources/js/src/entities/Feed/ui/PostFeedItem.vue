<script setup lang="ts">
import { computed } from 'vue'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import PostExtraStatus from '@/entities/Post/PostExtraStatus.vue'
import PostActions from '@/entities/Post/PostActions.vue'
import PostEntity from '@/entities/Post/PostEntity.vue'

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
})

const postStore = usePostStore()
const userStore = useUserStore()

const post = computed(() => {
    return postStore.getPostById(props.id)
})

const author = computed(() => {
    if (!post.value) return

    return userStore.getUserById(post.value.user_id)
})

const retweetedPost = computed(() => {
    if (!post.value) return null
    if (!post.value.retweeted_post_id) return null

    return postStore.getPostById(post.value.retweeted_post_id)
})

const postToRender = computed(() => {
    if (!post.value) return

    if (post.value.text.length) {
        return post.value
    } else if (post.value.retweeted_post_id && retweetedPost.value) {
        return retweetedPost.value
    } else {
        return post.value
    }
})
</script>

<template>
    <template v-if="post && author">
        <post-extra-status
            v-if="retweetedPost && post.text.length === 0"
            :text="`${author.name} сделал(-а) репост`"
            icon="retweet"
        />
        <post-entity
            v-if="postToRender"
            :post="postToRender"
        >
            <template #actions>
                <post-actions :post="postToRender" />
            </template>
        </post-entity>
    </template>
</template>
