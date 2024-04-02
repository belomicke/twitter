<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import PostFeed from '@/entities/Feed/ui/PostFeed.vue'
import { useFeedStore } from '@/entities/Feed/store'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

const feedId = computed(() => {
    return `post:${props.id}:thread_history`
})

const feedStore = useFeedStore()
const { getFeedById } = storeToRefs(feedStore)

const feed = computed(() => {
    return getFeedById.value(feedId.value)
})

const scrollBottom = ref<number>(0)

watch(() => feed.value, () => {
    const scroller = document.getElementById('scroll-element')

    if (!scroller) return

    setTimeout(() => {
        scroller.scroll(0, scroller.scrollHeight - scrollBottom.value)
        scrollBottom.value = scroller.scrollHeight - scroller.scrollTop
    })
}, { deep: true })

function fetch() {
    feedStore.fetchPostThreadHistoryFeed(props.id)
}
</script>

<template>
    <post-feed
        :id="feedId"
        trigger-side="top"
        window
        no-borders
        @fetch="fetch"
    />
</template>

<style scoped>

</style>
