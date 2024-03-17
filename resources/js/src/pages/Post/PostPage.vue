<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import PostPagePost from './ui/PostPagePost.vue'
import { usePostStore } from '@/entities/Post/store'
import XPageHeader from '@/shared/ui/XPageHeader/XPageHeader.vue'

const route = useRoute()

const id = computed(() => {
    return Number(route.params.id)
})

const postStore = usePostStore()

watch(() => id.value, () => postStore.fetchPostById(id.value))

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
