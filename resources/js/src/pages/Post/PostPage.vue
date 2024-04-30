<script setup lang="ts">
import { computed, onMounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { storeToRefs } from 'pinia'
import PostPageContent from '@/pages/Post/PostPageContent.vue'
import { usePostStore } from '@/entities/Post/store'
import XPageHeader from '@/shared/ui/XPageHeader/XPageHeader.vue'

const route = useRoute()
const postStore = usePostStore()
const { getPostById } = storeToRefs(postStore)

const id = computed(() => {
    return Number(route.params.id)
})

const post = computed(() => {
    return getPostById.value(id.value)
})

const element = ref<HTMLDivElement | null>(null)

onMounted(() => {
    postStore.fetchPostById(id.value)
    getScrollElement()
})

watch(id, () => {
    if (!post.value) {
        postStore.fetchPostById(id.value)
    }
})

function getScrollElement() {
    const el = document.getElementById('scroll-element') as HTMLDivElement

    if (el) {
        element.value = el
    }
}
</script>

<template>
    <x-page-header with-go-to-back-button>
        <h3 class="page-header-title">
            Опубликованный пост
        </h3>
    </x-page-header>
    <post-page-content
        v-if="element && post"
        :post="post"
        :element="element"
    />
</template>

<style scoped>
.page-header-title {
    display: flex;
    align-items: center;
    height: 100%;
    color: rgb(231, 233, 234);
    font-size: 19px;
    font-weight: 700;
}
</style>
