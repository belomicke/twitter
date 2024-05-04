<script setup lang="ts">
import { PropType } from 'vue'
import { IPost } from '@/shared/api/types/models/Post'
import RetweetExtensions from '@/entities/Post/ui/RetweetExtensions.vue'
import MediaPostExtension from '@/entities/Post/ui/MediaPostExtension/MediaPostExtension.vue'

defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    withRetweet: {
        type: Boolean,
        required: false,
        default: false
    },
    compact: {
        type: Boolean,
        required: false,
        default: false
    },
    withMediaModal: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>

<template>
    <div class="body">
        <div
            v-if="post.text.length"
            class="text"
        >
            {{ post.text }}
        </div>
        <div
            v-if="post.media_count"
            class="media"
            :class="{ compact: compact }"
        >
            <media-post-extension
                :post="post"
                :with-modal="withMediaModal"
            />
        </div>
        <div
            v-if="post.is_quote && post.retweeted_post_id && withRetweet"
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
    grid-gap: 10px;
    word-break: break-all;
    width: 100%;
}

.text {
    word-wrap: break-word;
    white-space: pre-wrap;
}

.retweet {
    cursor: pointer;
}

.media {
    border-radius: 15px;
    overflow: hidden;
}

.media.compact {
    border-radius: 0;
    overflow: auto;
}
</style>
