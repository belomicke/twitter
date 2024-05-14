<script setup lang="ts">
import { computed, onMounted, PropType, ref } from 'vue'
import { useVirtualizer } from '@tanstack/vue-virtual'
import XSpinner from "@/shared/ui/XSpinner/XSpinner.vue"

const props = defineProps({
    items: {
        type: Array as PropType<number[]>,
        required: true
    },
    hasNextPage: {
        type: Boolean,
        required: true
    },
    window: {
        type: Boolean,
        required: false,
        default: false
    },
    noBorders: {
        type: Boolean,
        required: false,
        default: false
    },
    triggerSide: {
        type: String as PropType<'top' | 'bottom'>,
        required: false,
        default: 'bottom'
    }
})

const emit = defineEmits(['fetch-next-page'])

const parentRef = ref<HTMLElement | null>(null)
const parentOffsetRef = ref(0)

const count = computed(() => {
    return props.items?.length
})

const element = computed(() => {
    if (!window) return parentRef.value

    return document.querySelector('#app')?.childNodes[0].childNodes[0] as Element
})

const rowVirtualizerOptions = computed(() => {
    return {
        getScrollElement: () => element.value,
        count: count.value,
        estimateSize: () => 255,
        scrollMargin: parentOffsetRef.value
    }
})

const rowVirtualizer = useVirtualizer(rowVirtualizerOptions)

const virtualRows = computed(() => rowVirtualizer.value.getVirtualItems())
const totalSize = computed(() => rowVirtualizer.value.getTotalSize())

const measureElement = (el: Element | null) => {
    if (!el) {
        return
    }

    rowVirtualizer.value.measureElement(el)

    return undefined
}

onMounted(() => {
    parentOffsetRef.value = parentRef.value?.offsetTop ?? 0
})

function fetchTriggerHandler(isVisible: boolean) {
    if (isVisible) {
        emit('fetch-next-page')
    }
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
                        virtualRows[0]?.start - rowVirtualizer.options.scrollMargin
                    }px)`,
                }"
            >
                <div
                    v-for="virtualRow in virtualRows"
                    :key="items[virtualRow.key]"
                    :ref="measureElement"
                    :data-index="virtualRow.index"
                >
                    <slot
                        :virtual-row="virtualRow"
                        name="item"
                    />
                </div>
            </div>
        </div>
    </div>
    <div
        v-if="hasNextPage"
        v-observe-visibility="fetchTriggerHandler"
        class="loader"
    >
        <x-spinner
            :size="30"
        />
    </div>
</template>

<style scoped>
.post-feed {
    padding-bottom: 15px;
}

.post-feed.scroll {
    overflow-y: auto;
}

.loader {
    display: flex;
    justify-content: center;
}
</style>
