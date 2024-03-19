<script setup lang="ts">
import { computed } from 'vue'
import { getFormattedPostPublishDate } from '@/entities/Post/helpers/getFormattedPostPublishDate'

const props = defineProps({
    date: {
        type: String,
        required: true
    }
})

const date = computed(() => {
    return getFormattedPostPublishDate(props.date)
})
</script>

<template>
    <span class="date">{{ date }}</span>
</template>

<style scoped>
.date {
    display: flex;
    align-items: center;
    color: rgb(113, 118, 123);
    line-height: 19px;
    font-size: 14px;
    font-weight: 400;
}
</style>
