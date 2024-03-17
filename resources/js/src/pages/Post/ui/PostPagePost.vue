<script setup lang="ts">

import PostActions from '@/entities/Post/PostActions.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import UserNames from '@/entities/User/ui/UserNames.vue'
import PostBody from '@/entities/Post/PostBody.vue'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import { computed } from 'vue'

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

const user = computed(() => {
    if (!post.value) return undefined

    return userStore.getUserById(post.value.user_id)
})
</script>

<template>
    <div
        v-if="post && user"
        class="post"
    >
        <div class="post-header">
            <user-avatar
                :username="user.username"
                :size="40"
                rounded
            />
            <user-names
                :user="user"
                links
            />
        </div>
        <post-body
            :post="post"
            with-retweet
        />
        <div class="actions">
            <post-actions
                :post="post"
                :icon-size="22"
            />
        </div>
    </div>
</template>

<style scoped>
.post {
    display: flex;
    flex-direction: column;
    grid-gap: 15px;
    padding: 15px;
}

.post-header {
    display: flex;
    grid-gap: 10px;
}

.actions {
    display: flex;
    align-items: center;
    border-top: 1px solid var(--x-border-color);
    border-bottom: 1px solid var(--x-border-color);
    padding: 10px 5px;
    height: 48px;
}
</style>
