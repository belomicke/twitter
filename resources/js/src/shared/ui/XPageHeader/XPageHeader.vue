<script setup lang="ts">
import XButton from '@/shared/ui/XButton/XButton.vue'
import { useRouter } from 'vue-router'

const router = useRouter()

defineProps({
    withGoToBackButton: {
        type: Boolean,
        required: false,
        default: false
    }
})

function goToBackHandler() {
    router.go(-1)
}
</script>

<template>
    <div class="x-page-header-wrapper">
        <div class="x-page-header">
            <div
                class="go-to-back-button"
                v-if="withGoToBackButton"
            >
                <x-button
                    icon="arrow-left"
                    size="large"
                    rounded
                    circle
                    text
                    @click="goToBackHandler"
                />
            </div>
            <div class="content">
                <slot/>
            </div>
        </div>
    </div>
</template>

<style scoped>
.x-page-header-wrapper {
    position: sticky;
    top: 0;
    height: 53px;
    background-color: rgba(0, 0, 0, 0.65);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.x-page-header {
    display: flex;
    width: 100%;
    height: 100%;
    padding-left: 10px;
}

.go-to-back-button {
    display: flex;
    align-items: center;
}

.go-to-back-button svg {
    height: 20px;
}

.content {
    width: 100%;
    padding: 0 10px;
}
</style>
