<script setup lang="ts">
import { computed } from 'vue'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import UserNames from '@/entities/User/ui/UserNames.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import PostActions from '@/entities/Post/ui/PostEntity/ui/PostActions/PostActions.vue'

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
</script>

<template>
    <div
        v-if="post && author"
        class="post-entity"
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
            </div>
            <div class="body">
                <div class="text">
                    {{ post.text }}
                </div>
            </div>
            <post-actions :post="post" />
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

.body {
    display: flex;
    flex-direction: column;
}

.content {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.text {
    white-space: pre-wrap;
}
</style>
