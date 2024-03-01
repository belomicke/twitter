<script setup lang="ts">
defineProps({
    title: {
        type: String,
        required: false,
        default: '',
    },
    subtitle: {
        type: String,
        required: false,
        default: '',
    },
})
</script>

<template>
    <div class="container">
        <div
            v-if="title.length"
            class="title"
        >
            {{ title }}
        </div>
        <div
            v-if="subtitle.length"
            class="subtitle"
        >
            {{ subtitle }}
        </div>
    </div>
</template>

<style scoped>
.container {
    display: flex;
    flex-direction: column;
    align-self: center;
    padding: 0 30px;
    margin: 30px auto;
    width: 100%;
    max-width: 400px;
}

.title {
    text-overflow: unset;
    color: rgb(231, 233, 234);
    margin-bottom: 10px;
    line-height: 36px;
    word-wrap: break-word;
    text-align: left;
    font-size: 31px;
    font-weight: 800;
}

.subtitle {
    text-overflow: unset;
    color: rgb(113, 118, 123);
    line-height: 20px;
    word-wrap: break-word;
    font-size: 15px;
    text-align: left;
    font-weight: 400;
    margin-bottom: 28px;
}
</style>
