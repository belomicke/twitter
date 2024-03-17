<script setup lang="ts">

import EmptyFeed from '@/entities/Feed/ui/EmptyFeed.vue'
import PostFeed from '@/entities/Feed/ui/PostFeed.vue'
import { useFeedStore } from '@/entities/Feed/store'
import { storeToRefs } from 'pinia'
import { computed, onMounted, watch } from 'vue'

const props = defineProps({
    query: {
        type: String,
        required: true,
    },
})

const feedStore = useFeedStore()
const { getFeedById } = storeToRefs(feedStore)

const feed = computed(() => {
    return getFeedById.value(`search:${props.query}`)
})

watch(() => props.query, (newQuery) => {
    feedStore.fetchPostsByQuery(newQuery)
})

onMounted(() => {
    feedStore.fetchPostsByQuery(props.query)
})

function fetch() {
    feedStore.fetchPostsByQuery(props.query)
}
</script>

<template>
    <post-feed
        v-if="feed"
        :id="`search:${props.query}`"
        @fetch="fetch"
    >
        <empty-feed
            :title="`По запросу «${query}» ничего не найдено`"
            subtitle="Попробуйте выполнить поиск по другому запросу."
        />
    </post-feed>
</template>

<style scoped>

</style>
