<script setup lang="ts">
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import PostExtraStatus from '@/entities/Post/ui/PostExtraStatus.vue'
import PostActions from '@/entities/Post/ui/PostActions.vue'
import PostEntity from '@/entities/Post/ui/PostEntity.vue'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

const router = useRouter()

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

function goToRetweeter() {
    const retweeter = author.value
    
    if (!retweeter) return

    router.push(`/profile/${retweeter.username}`)
}
</script>

<template>
    <div
        v-if="post && author"
        class="post"
    >
        <post-extra-status
            v-if="retweetedPost && post.text.length === 0"
            :text="`${author.name} сделал(-а) репост`"
            with-underline
            icon="retweet"
            @click="goToRetweeter"
        />
        <post-entity
            v-if="postToRender"
            :post="postToRender"
        >
            <template #actions>
                <post-actions :post="postToRender" />
            </template>
        </post-entity>
    </div>
</template>

<style scoped>
.post {
    cursor: pointer;
    transition: background-color 0.15s;
}

.post:hover {
    background-color: rgba(255, 255, 255, 0.03);
}
</style>
