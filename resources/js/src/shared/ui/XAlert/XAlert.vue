<script setup lang="ts">
import { PropType, ref } from 'vue'

defineProps({
    title: {
        type: String,
        required: true
    },
    type: {
        type: String as PropType<'success' | 'info' | 'warning' | 'error'>,
        required: true
    },
    effect: {
        type: String as PropType<'dark' | 'light'>,
        required: false,
        default: 'light'
    }
})

defineExpose({
    open,
    close
})

const active = ref<boolean>(false)

function open() {
    active.value = true
}

function close() {
    active.value = false
}

</script>

<template>
    <Teleport to="#portals">
        <Transition :duration="150">
            <div
                class="x-alert-wrapper"
                v-bind="$attrs"
                v-if="active"
            >
                <div
                    class="x-alert"
                    :class="{
                        'x-alert--success': type === 'success',
                        'x-alert--info': type === 'info',
                        'x-alert--warning': type === 'warning',
                        'x-alert--error': type === 'error',

                        'is-light': effect === 'light',
                        'is-dark': effect === 'dark',
                    }"
                >
                    {{ title }}
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
@import './types.css';

.x-alert-wrapper {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 600px;
    z-index: 10000;
}

.x-alert {
    --x-alert-padding: 8px 16px;
    --x-alert-border-radius-base: var(--x-border-radius-base);
    --x-alert-title-font-size: 13px;
    --x-alert-description-font-size: 12px;
    --x-alert-close-font-size: 12px;
    --x-alert-close-customed-font-size: 13px;
    --x-alert-icon-size: 16px;
    --x-alert-icon-large-size: 28px;
    width: 100%;
    max-width: 600px;
    cursor: pointer;
    user-select: none;
    padding: var(--x-alert-padding);
    box-sizing: border-box;
    border-radius: var(--x-alert-border-radius-base);
    background-color: var(--x-color-white);
    overflow: hidden;
    opacity: 1;
    display: flex;
    align-items: center;
    transition: opacity .15s;
}

.v-enter-active.x-alert-wrapper,
.v-leave-active.x-alert-wrapper {
    transition: transform .15s ease, opacity .15s ease;
}

.v-enter-from.x-alert-wrapper,
.v-leave-to.x-alert-wrapper {
    transform: translateX(-50%) scale(.85);
    opacity: 0;
}

.v-enter-to.x-alert-wrapper,
.v-leave-from.x-alert-wrapper {
    transform: translateX(-50%) scale(1);
    opacity: 1;
}
</style>
