<script setup lang="ts">
import { computed } from 'vue'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import UserNames from '@/entities/User/ui/UserNames.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import { useRouter } from 'vue-router'

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
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

function goToPostPage() {
    router.push(`/post/${props.id}`)
}

function mouseUpHandler() {
    const selection = window.getSelection()

    if (selection && !selection.toString()) {
        goToPostPage()
    }
}
</script>

<template>
    <div
        v-if="post && author"
        class="post-entity"
        @mouseup="mouseUpHandler"
    >
        <div class="avatar">
            <user-avatar
                :username="author.username"
                :size="40"
                rounded
            />
        </div>
        <div class="content">
            <div class="header">
                <user-names
                    :user="author"
                    inline
                    links
                />
                <div class="text">
                    {{ post.text }}
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.post-entity {
    display: flex;
    grid-gap: 10px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.15s;
}

.post-entity:hover {
    background-color: rgba(255, 255, 255, 0.03);
}

.text {
    white-space: pre-wrap;
}
</style>
