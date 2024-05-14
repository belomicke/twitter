<script setup lang="ts">
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import PostFeedItem from '@/widgets/Post/PostFeedItem/PostFeedItem.vue'
import { usePostStore } from '@/entities/Post/store'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

const postStore = usePostStore()
const { getPostById } = storeToRefs(postStore)

const post = computed(() => {
    return getPostById.value(props.id)
})

</script>

<template>
    <post-feed-item
        v-if="post && !post.is_deleted"
        :id="id"
        no-answer
        is-thread-if-have-comments
    />
</template>
