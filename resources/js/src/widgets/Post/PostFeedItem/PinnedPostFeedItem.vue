<script setup lang="ts">

import PostFeedItemEntity from '@/widgets/Post/PostFeedItem/PostFeedItemEntity.vue'

defineProps({
    id: {
        type: Number,
        required: true
    },
    withOptions: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>

<template>
    <post-feed-item-entity
        :id="id"
        :with-options="withOptions"
        :extra-status-options="{
            visible: true,
            icon: 'pin',
            text: 'Закреплено',
            iconIsFilled: true
        }"
    />
</template>
