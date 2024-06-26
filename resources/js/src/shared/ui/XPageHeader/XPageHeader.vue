<script setup lang="ts">
import { useRouter } from 'vue-router'

import XButton from '@/shared/ui/XButton/XButton.vue'

const router = useRouter()

const props = defineProps({
    withGoToBackButton: {
        type: Boolean,
        required: false,
        default: false
    },
    onBack: {
        type: Function,
        default: null
    }
})

const emit = defineEmits(['back'])

function goToBackHandler() {
    if (!props.onBack) router.go(-1)

    emit('back')
}
</script>

<template>
    <div class="x-page-header-wrapper">
        <div class="x-page-header">
            <div
                v-if="withGoToBackButton"
                class="go-to-back-button"
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
            <div
                class="content"
                :class="{'with-no-go-back-button': !withGoToBackButton}"
            >
                <slot />
            </div>
        </div>
    </div>
</template>

<style scoped>
.x-page-header-wrapper {
    position: sticky;
    top: 0;
    height: 54px;
    background-color: rgba(0, 0, 0, 0.65);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 999;
}

.x-page-header {
    display: flex;
    width: 100%;
    height: 100%;
    padding-left: 15px;
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

.content.with-no-go-back-button {
    padding: 0;
    padding-right: 15px;
}
</style>
