<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({
    count: {
        type: Number,
        required: true,
    },
})

const formattedCount = computed(() => {
    if (props.count >= 1000 && props.count < 1000000) {
        return `${Math.floor(props.count / 1000)} тыс.`
    } else if (props.count >= 1000000) {
        return `${Math.floor(props.count / 1000000)} млн.`
    } else {
        return props.count
    }
})
</script>

<template>
    <span
        class="count"
    >
        {{ formattedCount }}
    </span>
</template>

<style scoped>
.count {
    font-size: 13px;
    line-height: 18px;
    color: rgb(113, 118, 123);
    transition: color .15s;
}
</style>
