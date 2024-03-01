<script setup lang="ts">
import { PropType } from 'vue'

interface ITab {
    text: string
    active: boolean
    onClick: () => void
}

defineProps({
    tabs: {
        type: Array as PropType<ITab[]>,
        required: true,
    },
})
</script>

<template>
    <div class="x-tabs">
        <div
            v-for="(tab, index) in tabs"
            :key="index"
            class="tab"
            :class="{
                active: tab.active
            }"
            @click="tab.onClick"
        >
            {{ tab.text }}
        </div>
    </div>
</template>

<style scoped>
.x-tabs {
    display: flex;
    height: 50px;
    padding: 5px;
    grid-gap: 5px;
    width: 100%;
}

.tab {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    cursor: pointer;
    color: rgb(113, 118, 123);
    transition: .15s;
    border-radius: 10px;
}

.tab.active {
    color: rgb(255, 255, 255);
    font-weight: 700;
    background-color: var(--x-color-primary-opacity-2);
}
</style>
