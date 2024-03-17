<script setup lang="ts">
import { PropType } from 'vue'
import { PostLikeActionButton } from '@/features/post/like-post'
import { PostRetweetActionButton } from '@/features/post/retweet-post'
import { IPost } from '@/shared/api/types/models/Post'

defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true,
    },
    iconSize: {
        type: Number,
        required: false,
        default: 18,
    },
})

</script>

<template>
    <div class="post-actions">
        <div class="post-action-button">
            <post-retweet-action-button
                :post="post"
                :icon-size="iconSize"
            />
        </div>
        <div class="post-action-button">
            <post-like-action-button
                :post="post"
                :icon-size="iconSize"
            />
        </div>
    </div>
</template>

<style scoped>
.post-actions {
    display: grid;
    grid-template-columns: 80px 80px;
    grid-gap: 40px;
    justify-content: start;
    width: 100%;
}

.post-action-button {
    display: flex;
    justify-content: start;
}
</style>
