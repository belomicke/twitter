<script setup lang="ts">
defineProps({
    username: {
        type: String,
        required: true
    }
})
</script>

<template>
    <span class="user-username">
        @{{ username }}
    </span>
</template>

<style scoped>
.user-username {
    color: var(--x-color-primary);
}
</style>
