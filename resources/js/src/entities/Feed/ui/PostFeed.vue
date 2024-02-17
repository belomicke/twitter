<script setup lang="ts">
import 'v3-infinite-loading/lib/style.css'

import {
    computed,
    onMounted,
} from 'vue'

import { storeToRefs } from 'pinia'

import PostEntity from '@/entities/Post/ui/PostEntity.vue'
import XVirtualScroll from '@/shared/ui/XVirtualScroll/XVirtualScroll.vue'

import { useFeedStore } from '../store'

const { id } = defineProps({
    id: {
        type: String,
        required: true
    },
    window: {
        type: Boolean,
        required: false,
        default: false
    }
})

const emit = defineEmits(['fetch'])

const feedStore = useFeedStore()
const { getFeedById } = storeToRefs(feedStore)

const feed = computed(() => {
    return getFeedById.value(id)
})

onMounted(() => {
    if (Boolean(feed.value && feed.value?.data.items.length !== 0)) return

    emit('fetch')
})

function load() {
    if (feed.value?.data.items.length === feed.value?.data.total) return

    emit('fetch')
}
</script>

<template>
    <x-virtual-scroll
        v-if="feed && feed.data.items.length && feed.data.total"
        :count="feed.data.items.length"
        :total="feed.data.total"
        :window="window"
        @fetch-next-page="load"
    >
        <template #item="{ virtualRow }">
            <post-entity
                :id="feed.data.items[virtualRow.index]"
            />
        </template>
    </x-virtual-scroll>
</template>

<style scoped>
</style>
