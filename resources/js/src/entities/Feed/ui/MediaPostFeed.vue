<script setup lang="ts">
import { computed, onMounted, watch } from "vue"
import { storeToRefs } from "pinia"
import { useFeedStore } from "@/entities/Feed/store"
import XVirtualScroll from "@/shared/ui/XVirtualScroll/XVirtualScroll.vue"
import XSpinner from "@/shared/ui/XSpinner/XSpinner.vue"
import MediaPostFeedItem from "@/widgets/Post/MediaPostFeedItem.vue"
import _ from "lodash"

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

const rows = computed(() => {
    if (!feed.value) return []

    const items = feed.value.data.items
    return _.chunk(items, 3)
})

onMounted(() => {
    if (hasNextPage.value) return

    emit('fetch')
})

const hasNextPage = computed(() => {
    if (!feed.value) return false
    console.log(feed.value.data.items.length)
    console.log(feed.value.data.total)
    return feed.value.data.items.length < feed.value.data.total
})

function load() {
    if (!feed.value) return

    if (hasNextPage.value) return

    emit('fetch')
}
</script>

<template>
    <x-virtual-scroll
        v-if="feed && !renderSlot && rows"
        :has-next-page="hasNextPage"
        :items="Array.from(new Array(rows.length))"
        :window="window"
        no-borders
        @fetch-next-page="load"
    >
        <template #item="{ virtualRow }">
            <div
                v-if="rows"
                class="row"
            >
                <media-post-feed-item
                    v-for="item in rows[virtualRow.index]"
                    :id="item"
                    :key="item"
                />
            </div>
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

.row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 5px;
    width: 100%;
    margin-bottom: 5px;
}
</style>
