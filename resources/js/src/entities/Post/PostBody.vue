<script setup lang="ts">
import { PropType } from 'vue'
import { IPost } from '@/shared/api/types/models/Post'
import RetweetExtensions from '@/entities/Post/RetweetExtensions.vue'

defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true,
    },
    withRetweet: {
        type: Boolean,
        required: false,
        default: false,
    },
})
</script>

<template>
    <div class="body">
        <div class="text">
            {{ post.text }}
        </div>
        <div
            v-if="post.retweeted_post_id && withRetweet"
            class="retweet"
        >
            <retweet-extensions
                :id="post.retweeted_post_id"
                go-to-post-on-click
            />
        </div>
    </div>
</template>

<style scoped>
.body {
    display: flex;
    flex-direction: column;
}

.text {
    white-space: pre-wrap;
}

.retweet {
    cursor: pointer;
    margin-top: 10px;
}
</style>
