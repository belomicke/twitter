<script setup lang="ts">
import { useRoute, useRouter } from 'vue-router'
import { usePostStore } from '@/entities/Post/store'
import { computed, onMounted } from 'vue'
import XPageHeader from '@/shared/ui/XPageHeader/XPageHeader.vue'
import { useUserStore } from '@/entities/User/store'
import PostPagePost from '@/pages/Post/ui/PostPagePost.vue'

const router = useRouter()
const route = useRoute()

const id = computed(() => {
    return Number(route.params.id)
})

const postStore = usePostStore()
const userStore = useUserStore()

const post = computed(() => {
    return postStore.getPostById(id.value)
})

const user = computed(() => {
    if (!post.value) return undefined

    return userStore.getUserById(post.value.user_id)
})

onMounted(() => {
    postStore.fetchPostById(id.value)
})
</script>

<template>
    <x-page-header with-go-to-back-button>
        <div class="page-header-title">
            Опубликованный пост
        </div>
    </x-page-header>
    <div class="container">
        <post-page-post :id="id" />
    </div>
</template>

<style scoped>
.page-header-title {
    display: flex;
    align-items: center;
    font-size: 20px;
    font-weight: 700;
    height: 100%;
}

.container {
    display: flex;
    flex-direction: column;
}

</style>
