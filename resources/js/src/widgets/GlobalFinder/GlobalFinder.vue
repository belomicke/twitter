<script setup lang="ts">

import { onMounted, onUnmounted, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import GlobalFinderResult from './GlobalFinderResult.vue'
import XSearchInput from '@/shared/ui/XSearchInput/XSearchInput.vue'

const route = useRoute()

const value = ref<string>(route.path === '/search' ? String(route.query.q ?? '') : '')
const visible = ref<boolean>(false)

const container = ref<HTMLDivElement | null>(null)

onMounted(() => {
    window.addEventListener('click', clickOutside)
})

onUnmounted(() => {
    window.removeEventListener('click', clickOutside)
})

watch(value, (newValue) => newValue.length && open())
watch(() => route.query.q, () => visible.value = false)

function clickOutside(e: MouseEvent) {
    const element = container.value

    if (!element) return

    const target = e.target as HTMLElement

    if (!element.contains(target)) visible.value = false
}

function open() {
    visible.value = true
}

function close() {
    visible.value = false
}
</script>

<template>
    <div
        ref="container"
        class="wrapper"
    >
        <x-search-input
            v-model="value"
            @focus="visible = true"
        />
        <div
            class="results"
            :class="{ 'visible': visible }"
        >
            <global-finder-result
                :query="value"
                @close="close"
            />
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    height: 42px;
    width: 100%;
}

.results {
    opacity: 0;
    transform: scale(.99);
    pointer-events: none;
    transition: opacity .15s, transform .15s;
}

.results.visible {
    transform: scale(1);
    opacity: 1;
    pointer-events: auto;
}
</style>
