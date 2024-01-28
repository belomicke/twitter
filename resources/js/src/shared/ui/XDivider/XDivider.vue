<script setup lang="ts">
import { PropType } from 'vue'

defineProps({
    contentPosition: {
        type: String as PropType<'left' | 'center' | 'right'>,
        required: false,
        default: 'center'
    }
})
</script>

<template>
    <div class="x-divider">
        <div
            class="x-divider__text"
            :class="{
                'is-left': contentPosition === 'left',
                'is-center': contentPosition === 'center',
                'is-right': contentPosition === 'right'
            }"
            v-if="$slots.default"
        >
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
.x-divider {
    display: block;
    height: 1px;
    width: 100%;
    margin: 24px 0;
    border-top: 1px var(--x-border-color) var(--x-border-style);
    position: relative;
}

.x-divider__text {
    position: absolute;
    background-color: var(--x-color-black);
    padding: 0 20px;
    font-weight: 500;
    color: var(--x-text-color-primary);
    font-size: 14px;
}

.x-divider__text.is-left {
    left: 20px;
    transform: translateY(-50%);
}

.x-divider__text.is-center {
    left: 50%;
    transform: translate(-50%) translateY(-50%);
}

.x-divider__text.is-right {
    right: 20px;
    transform: translateY(-50%);
}
</style>
