<script setup lang="ts">
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import UserNames from '@/entities/User/ui/UserNames.vue'
import PostBody from '@/entities/Post/PostBody.vue'
import { useRouter } from 'vue-router'

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
    goToPostOnClick: {
        type: Boolean,
        required: false,
        default: false,
    },
})

const router = useRouter()

const postStore = usePostStore()
const userStore = useUserStore()

const { getPostById } = storeToRefs(postStore)
const { getUserById } = storeToRefs(userStore)

const post = computed(() => {
    return getPostById.value(props.id)
})

const user = computed(() => {
    if (!post.value) return null

    return getUserById.value(post.value.user_id)
})

function clickHandler() {
    if (props.goToPostOnClick) {
        router.push(`/post/${props.id}`)
    }
}
</script>

<template>
    <div
        v-if="post && user"
        class="retweet-extension"
        @click.stop="clickHandler"
    >
        <div class="header">
            <user-avatar
                :username="user.username"
                :size="24"
                rounded
            />
            <user-names
                :user="user"
                inline
            />
        </div>
        <post-body :post="post" />
    </div>
    <div
        v-else
        class="deleted"
    >
        <span class="deleted-text">Этот пост недоступен.</span>
    </div>
</template>

<style scoped>
.retweet-extension {
    display: flex;
    flex-direction: column;
    grid-gap: 5px;
    border: 1px solid var(--x-border-color);
    background-color: var(--x-bg-color-page);
    border-radius: 15px;
    padding: 10px;
    transition: background-color .15s;
}

.retweet-extension:hover {
    background-color: rgba(255, 255, 255, .03)
}

.header {
    display: flex;
    align-items: center;
    grid-gap: 5px;
}

.deleted {
    display: flex;
    align-items: center;
    background-color: rgb(22, 24, 28);
    padding: 10px 5px;
    border: 1px solid rgb(32, 35, 39);
    border-radius: 15px;
}

.deleted-text {
    margin: 0 10px;
    color: rgb(113, 118, 123);
    line-height: 20px;
    word-wrap: break-word;
    font-size: 15px;
    font-weight: 400;
}
</style>
