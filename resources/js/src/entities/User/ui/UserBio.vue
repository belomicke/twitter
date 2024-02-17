<script setup lang="ts">
defineProps({
    bio: {
        type: String,
        required: true
    }
})
</script>

<template>
    <div class="bio">
        {{ bio }}
    </div>
</template>

<style scoped>
.bio {
    color: rgb(231, 233, 234);
    line-height: 20px;
    word-wrap: break-word;
    font-size: 15px;
    font-weight: 400;
}
</style>
