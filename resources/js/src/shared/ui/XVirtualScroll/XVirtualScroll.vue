<script setup lang="ts">
import { computed, onMounted, PropType, ref } from 'vue'

import InfiniteLoading from 'v3-infinite-loading'

import { useVirtualizer } from '@tanstack/vue-virtual'

const props = defineProps({
    items: {
        type: Array as PropType<number[]>,
        required: true,
    },
    count: {
        type: Number,
        required: true,
    },
    total: {
        type: Number,
        required: true,
    },
    window: {
        type: Boolean,
        required: false,
        default: false,
    },
})

const emit = defineEmits(['fetch-next-page'])

const parentRef = ref<HTMLElement | null>(null)
const parentOffsetRef = ref(0)

const element = computed(() => {
    if (!window) return parentRef.value

    return document.querySelector('#app')?.childNodes[0].childNodes[0] as Element
})

const rowVirtualizerOptions = computed(() => {
    return {
        getScrollElement: () => element.value,
        count: props.count,
        estimateSize: () => 255,
        scrollMargin: parentOffsetRef.value,
    }
})

const rowVirtualizer = useVirtualizer(rowVirtualizerOptions)

const virtualRows = computed(() => rowVirtualizer.value.getVirtualItems())
const totalSize = computed(() => rowVirtualizer.value.getTotalSize())

const measureElement = (el) => {
    if (!el) {
        return
    }

    rowVirtualizer.value.measureElement(el)

    return undefined
}

onMounted(() => {
    parentOffsetRef.value = parentRef.value?.offsetTop ?? 0
})

const hasNextPage = computed(() => {
    return props.count < props.total
})

function fetchNextPage() {
    if (props.count === props.total) return

    emit('fetch-next-page')
}
</script>

<template>
    <div
        ref="parentRef"
        class="post-feed"
        :class="{
            'scroll': !props.window
        }"
    >
        <div
            :style="{
                height: `${totalSize}px`,
                width: '100%',
                position: 'relative',
            }"
        >
            <div
                :style="{
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    width: '100%',
                    transform: `translateY(${
                        virtualRows[0]?.start - rowVirtualizer.options.scrollMargin ?? 0
                    }px)`,
                }"
            >
                <div
                    v-for="virtualRow in virtualRows"
                    :key="items[virtualRow.key]"
                    :ref="measureElement"
                    :data-index="virtualRow.index"
                    class="post"
                >
                    <slot
                        :virtual-row="virtualRow"
                        name="item"
                    />
                </div>
            </div>
        </div>
        <div
            v-if="hasNextPage"
            class="loader"
        >
            <infinite-loading @infinite="fetchNextPage" />
        </div>
    </div>
</template>

<style scoped>
.post-feed {
    padding-bottom: 10px;
}

.post-feed.scroll {
    height: 100%;
    overflow-y: auto;
}

.post {
    border-bottom: 1px solid var(--x-border-color);
}

.loader {
    display: flex;
    justify-content: center;
    padding-top: 14px;
}
</style>
