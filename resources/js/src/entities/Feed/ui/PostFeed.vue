<script setup lang="ts">
import { computed, onMounted, PropType, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { useFeedStore } from '../store'
import PostFeedItem from '@/widgets/Post/PostFeedItem/PostFeedItem.vue'
import XSpinner from '@/shared/ui/XSpinner/XSpinner.vue'
import XVirtualScroll from '@/shared/ui/XVirtualScroll/XVirtualScroll.vue'
import 'v3-infinite-loading/lib/style.css'

const props = defineProps({
    id: {
        type: String,
        required: true
    },
    window: {
        type: Boolean,
        required: false,
        default: false
    },
    triggerSide: {
        type: String as PropType<'top' | 'bottom'>,
        required: false,
        default: 'bottom'
    },
    noBorders: {
        type: Boolean,
        required: false,
        default: false
    },
    withPinnedPost: {
        type: Boolean,
        required: false,
        default: false
    }
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

const hasNextPage = computed(() => {
    if (!feed.value) return false

    return feed.value.data.items.length < feed.value.data.total
})

onMounted(() => {
    if (hasNextPage.value) return

    emit('fetch')
})

function load() {
    if (!feed.value) return

    if (hasNextPage.value) return

    emit('fetch')
}
</script>

<template>
    <x-virtual-scroll
        v-if="feed && !renderSlot"
        :items="feed.data.items"
        :trigger-side="triggerSide"
        :window="window"
        :no-borders="noBorders"
        :has-next-page="hasNextPage"
        @fetch-next-page="load"
    >
        <template #item="{ virtualRow }">
            <post-feed-item
                :id="feed.data.items[virtualRow.index]"
                :can-be-pinned="withPinnedPost"
                with-options
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
