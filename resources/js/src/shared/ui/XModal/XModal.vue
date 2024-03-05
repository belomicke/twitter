<script setup lang="ts">
import { ref } from 'vue'

defineProps({
    centered: {
        type: Boolean,
        required: false,
        default: false,
    },
    maxContentWidth: {
        type: Number,
        required: false,
        default: 600,
    },
})

defineEmits(['close'])

defineExpose({
    open,
    close,
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
                v-if="active"
                class="modal"
            >
                <div
                    class="background"
                    @click="$emit('close')"
                />
                <div
                    class="content"
                    :class="{
                        'centered': centered
                    }"
                    :style="{
                        'max-width': `${maxContentWidth}px`,
                        'width': '100%'
                    }"
                >
                    <slot />
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style lang="css" scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    transition: opacity .15s;
}

.background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(91, 112, 131, 0.4);
    z-index: 10001;
    transition: opacity .15s;
}

.content {
    position: relative;
    z-index: 10002;
}

.content.centered {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(calc(-50% - 33px), -50%);
}

.v-enter-active.modal,
.v-leave-active.modal {
    transition: opacity .150s ease;
}

.v-enter-from.modal,
.v-leave-to.modal {
    opacity: 0;
}

.v-enter-active .content,
.v-leave-active .content {
    transition: all .150s ease;
}

.v-enter-from .content,
.v-leave-to .content {
    transform: translate(calc(-50% - 33px), -50%) scale(.85);
}

.v-enter-to .content,
.v-leave-from .content {
    transform: translate(calc(-50% - 33px), -50%) scale(1);
}
</style>
