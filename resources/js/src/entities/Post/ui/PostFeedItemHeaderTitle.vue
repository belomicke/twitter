<script setup lang="ts">

import PostPublishDate from '@/entities/Post/ui/PostPublishDate.vue'
import UserNames from '@/entities/User/ui/UserNames.vue'
import { computed } from 'vue'
import { usePostStore } from '@/entities/Post/store'
import { storeToRefs } from 'pinia'
import { useUserStore } from '@/entities/User/store'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

const postStore = usePostStore()
const { getPostById } = storeToRefs(postStore)

const userStore = useUserStore()
const { getUserById } = storeToRefs(userStore)

const post = computed(() => {
    return getPostById.value(props.id)
})

const user = computed(() => {
    if (!post.value) return null

    return getUserById.value(post.value.user_id)
})
</script>

<template>
    <div
        v-if="post && user"
        class="post-header-title"
    >
        <user-names
            :user="user"
            inline
            links
        />
        <span class="separator">·</span>
        <post-publish-date :date="post.created_at" />
    </div>
</template>

<style scoped>
.post-header-title {
    display: flex;
}

.separator {
    margin: 0 5px;
    color: rgb(113, 118, 123);
}
</style>
