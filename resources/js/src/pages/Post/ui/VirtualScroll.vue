<script setup lang="ts">
import { computed, PropType, ref } from 'vue'
import { useVirtualizer } from '@tanstack/vue-virtual'
import { IPost } from '@/shared/api/types/models/Post'
import InfiniteLoading from 'v3-infinite-loading'

const props = defineProps({
    items: {
        type: Array as PropType<string[]>,
        required: true
    },
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    element: {
        type: HTMLDivElement,
        required: true
    },
    topTriggerIsVisible: {
        type: Boolean,
        required: false,
        default: false
    },
    bottomTriggerIsVisible: {
        type: Boolean,
        required: false,
        default: false
    }
})

const emit = defineEmits(['top-handler', 'bottom-handler'])

const parentRef = ref<HTMLElement | null>(null)

const count = computed(() => {
    if (!props.items) return 0

    return props.items.length
})

const rowVirtualizerOptions = computed(() => {
    return {
        count: count.value,
        getScrollElement: () => props.element,
        estimateSize: () => 200,
        overscan: 5
    }
})

const rowVirtualizer = useVirtualizer(rowVirtualizerOptions)
const virtualRows = computed(() => rowVirtualizer.value.getVirtualItems())
const totalSize = computed(() => rowVirtualizer.value.getTotalSize())

defineExpose({
    scrollToIndex: rowVirtualizer.value.scrollToIndex
})

function measureElement(el: Element | null) {
    if (!el) {
        return
    }

    rowVirtualizer.value.measureElement(el)

    return undefined
}

function topTriggerHandler() {
    emit('top-handler')
}

function bottomTriggerHandler() {
    emit('top-handler')
}
</script>

<template>
    <div
        ref="parentRef"
        class="post-feed scroll"
    >
        <div
            v-if="topTriggerIsVisible"
            class="loader top"
        >
            <infinite-loading
                @infinite="topTriggerHandler"
            />
        </div>
        <div
            :style="{
                height: `${totalSize}px`,
                width: '100%',
                position: 'relative',
            }"
        >
            <div
                v-for="virtualRow in virtualRows"
                :key="items[virtualRow.key]"
                :ref="measureElement"
                class="post"
                :data-index="virtualRow.index"
                :style="{
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    width: '100%',
                    transform: `translateY(${virtualRow.start}px)`,
                }"
            >
                <slot :virtual-row="virtualRow" />
            </div>
        </div>
        <div
            v-if="bottomTriggerIsVisible"
            class="loader bottom"
        >
            <infinite-loading @infinite="bottomTriggerHandler" />
        </div>
    </div>
</template>

<style scoped>
.post-feed {
    position: relative;
}

.loader {
    display: flex;
    justify-content: center;
    padding: 15px 0;
    position: absolute;
    height: 0;
    opacity: 0;
}

.loader.top {
    top: 0;
}

.loader.bottom {
    bottom: 0;
}
</style>
