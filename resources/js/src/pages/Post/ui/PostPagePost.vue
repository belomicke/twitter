<script setup lang="ts">

import { computed } from 'vue'
import { useUserStore } from '@/entities/User/store'
import { usePostStore } from '@/entities/Post/store'
import PostBody from '@/entities/Post/ui/PostBody.vue'
import UserNames from '@/entities/User/ui/UserNames.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import PostActions from '@/entities/Post/ui/PostActions.vue'
import moment from 'moment'
import PostOptions from '@/entities/Post/ui/PostOptions/PostOptions.vue'
import { useRouter } from 'vue-router'

const props = defineProps({
    id: {
        type: Number,
        required: true
    },
    hasThread: {
        type: Boolean,
        required: false,
        default: false
    }
})

const router = useRouter()

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

    return n.format('D MMM YYYY')
})

function goToAuthor() {
    if (!user.value) return

    router.push(`/profile/${user.value.username}`)
}
</script>

<template>
    <div
        v-if="post && user"
        class="post"
        :class="{
            'has-thread': hasThread
        }"
    >
        <div class="post-header">
            <div class="post-header-left">
                <user-avatar
                    :username="user.username"
                    :size="40"
                    rounded
                    @click="goToAuthor"
                />
                <user-names
                    :user="user"
                    links
                />
            </div>
            <div class="post-header-right">
                <post-options :post="post" />
            </div>
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
    padding: 15px 15px 0;
    position: relative;
}

.post.has-thread::before {
    content: "";
    width: 2px;
    height: 8px;
    position: absolute;
    top: 0;
    left: calc(15px + 19px);
    background-color: var(--x-border-color);
}

.post-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.post-header-left {
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
