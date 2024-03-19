<script setup lang="ts">

import { computed } from 'vue'
import { useUserStore } from '@/entities/User/store'
import { usePostStore } from '@/entities/Post/store'
import PostBody from '@/entities/Post/ui/PostBody.vue'
import UserNames from '@/entities/User/ui/UserNames.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import PostActions from '@/entities/Post/ui/PostActions.vue'
import moment from 'moment'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
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

const time = computed(() => {
    if (!post.value) return ''

    const n = moment(post.value.created_at)

    return n.format('hh:mm:ss')
})

const date = computed(() => {
    if (!post.value) return ''

    const n = moment(post.value.created_at)

    return n.format('DD MMM YYYY')
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
        <div class="publish-date">
            {{ time }} · {{ date }}
        </div>
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

.publish-date {
    display: flex;
    align-items: center;
    color: rgb(113, 118, 123);
    line-height: 19px;
    font-size: 14px;
    font-weight: 400;
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
