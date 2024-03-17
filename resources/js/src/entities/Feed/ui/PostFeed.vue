<script setup lang="ts">
import { computed, onMounted, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { useFeedStore } from '../store'
import PostFeedItem from './PostFeedItem.vue'
import XSpinner from '@/shared/ui/XSpinner/XSpinner.vue'
import XVirtualScroll from '@/shared/ui/XVirtualScroll/XVirtualScroll.vue'
import 'v3-infinite-loading/lib/style.css'

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    window: {
        type: Boolean,
        required: false,
        default: false,
    },
})

const emit = defineEmits(['fetch'])

const feedStore = useFeedStore()
const { getFeedById } = storeToRefs(feedStore)

const feed = computed(() => {
    return getFeedById.value(props.id)
})

watch(() => props.id, () => {
    emit('fetch')
})

const renderSlot = computed(() => {
    return feed.value && feed.value.data.items.length === 0 && feed.value.data.total === 0
})

onMounted(() => {
    if (Boolean(feed.value && feed.value?.data.items.length !== 0)) return

    emit('fetch')
})

function load() {
    if (!feed.value) return

    if (Boolean(feed.value.data.items.length >= feed.value.data.total)) return

    emit('fetch')
}
</script>

<template>
    <x-virtual-scroll
        v-if="feed && !renderSlot"
        :items="feed.data.items"
        :total="feed.data.total ?? 0"
        :window="window"
        @fetch-next-page="load"
    >
        <template #item="{ virtualRow }">
            <post-feed-item
                :id="feed.data.items[virtualRow.index]"
            />
        </template>
    </x-virtual-scroll>
    <slot v-else-if="renderSlot" />
    <div
        v-else
        class="loader"
    >
        <x-spinner
            :size="30"
        />
    </div>
</template>

<style scoped>
.loader {
    display: flex;
    justify-content: center;
    margin-top: 15px;
}
</style>
