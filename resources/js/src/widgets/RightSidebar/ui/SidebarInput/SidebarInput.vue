<script setup lang="ts">
import { onMounted, onUnmounted, ref, watch } from 'vue'
import SidebarInputResult from './SidebarInputResult.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

const value = ref<string>('')
const visible = ref<boolean>(false)

const container = ref<HTMLDivElement | null>(null)
const input = ref<HTMLInputElement | null>(null)

onMounted(() => {
    window.addEventListener('click', clickOutside)
})

onUnmounted(() => {
    window.removeEventListener('click', clickOutside)
})

watch(value, () => open())

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
    value.value = ''
}

function focus() {
    if (!input.value) return

    open()
    input.value.focus()
}
</script>

<template>
    <div
        ref="container"
        class="wrapper"
    >
        <div class="sidebar-input">
            <div class="icon">
                <x-icon icon="search" />
            </div>
            <input
                ref="input"
                v-model="value"
                placeholder="Поиск"
                class="input"
            >
            <div
                class="icon right"
                :class="{
                    visible: value.length !== 0
                }"
                @click="value = ''"
            >
                <x-icon icon="cross" />
            </div>
        </div>
        <div
            class="results"
            :class="{ 'visible': visible }"
        >
            <sidebar-input-result
                :query="value"
                @close="close"
            />
        </div>
    </div>
</template>

<style scoped>
.sidebar-input {
    display: flex;
    align-items: center;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
    background-color: rgb(32, 35, 39);
    border: 1px solid rgb(32, 35, 39);
    transition: border-color .15s;
}

.sidebar-input:focus-within {
    border-color: var(--x-color-primary);
}

.icon {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    padding-left: 10px;
    transition: color .15s;
}

.icon.right {
    border-radius: 50%;
    padding: 5px;
    margin-right: 10px;
    cursor: pointer;
    transform: scale(0);
    transition: background-color .15s, transform .15s;
}

.icon.right.visible {
    transform: scale(1);
}

.icon.right:hover {
    background-color: rgba(255, 255, 255, .1);
}

.icon svg {
    color: rgb(113, 118, 123) !important;
    transition: color .15s;
}

.sidebar-input:focus-within svg {
    color: var(--x-color-primary) !important;
}

.input {
    outline: none;
    border: 0;
    padding: 10px;
    width: 100%;
    color: rgb(231, 233, 234);
    line-height: 20px;
    font-size: 15px;
    font-weight: 400;
    background-color: transparent;
}

.results {
    opacity: 0;
    transform: translateY(-50px) scale(0);
    pointer-events: none;
    transition: opacity .15s, transform .15s;
}

.sidebar-input:focus-within + .results,
.results.visible {
    transform: translateY(0) scale(1);
    opacity: 1;
    pointer-events: auto;
}
</style>
