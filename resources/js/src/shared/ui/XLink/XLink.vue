<script setup lang="ts">
import { computed } from 'vue'

const { href } = defineProps({
    href: {
        type: String,
        required: true
    },
    blank: {
        type: Boolean,
        required: false,
        default: false
    }
})

const linkText = computed(() => {
    if (href?.includes('http://')) {
        return href.split('http://')[1]
    } else {
        return href.split('https://')[1]
    }
})

function linkClickHandler(e: MouseEvent) {
    e.preventDefault()
    window.open(href, '_blank')
}

</script>

<template>
    <div class="x-link" @click="linkClickHandler">{{ linkText }}</div>
</template>

<style scoped>
.x-link {
    cursor: pointer;
    color: var(--x-color-primary);
    font-size: 15px;
}

.x-link:hover {
    text-decoration: underline;
}
</style>
