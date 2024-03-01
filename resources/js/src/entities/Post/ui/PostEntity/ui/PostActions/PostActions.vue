<script setup lang="ts">

import { PropType } from 'vue'
import PostLikeActionButton from './ui/PostLikeActionButton.vue'
import { IPost } from '@/shared/api/types/models/Post'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true,
    },
})

</script>

<template>
    <div class="post-actions">
        <post-like-action-button :post="post" />
    </div>
</template>

<style scoped>
.post-actions {
    display: flex;
    grid-gap: 5px;
    width: 100%;
    padding-top: 10px;
}
</style>
