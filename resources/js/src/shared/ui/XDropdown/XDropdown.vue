<script setup lang="ts">
import { onMounted, onUnmounted, PropType, ref } from 'vue'
import { observePosition } from '@/shared/helpers/observePositionOfElement'
import { observeSize } from '@/shared/helpers/observeSizeOfElement'

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: false
    },
    xSide: {
        type: String as PropType<'left' | 'right'>,
        required: false,
        default: 'right'
    }
})

const emit = defineEmits(['update:modelValue'])

defineExpose({
    open,
    close
})

const container = ref<HTMLDivElement | null>(null)
const element = ref<HTMLDivElement | null>(null)
const dropdownRef = ref<HTMLDivElement | null>(null)
const dropdownIsOpen = ref<boolean>(false)

const elementHeight = ref<number>(0)
const elementWidth = ref<number>(0)

const xProperty = ref<number>(0)
const yProperty = ref<number>(0)

const ySide = ref<'top' | 'bottom'>('top')
const xSide = ref<'left' | 'right'>(props.xSide)

const elementRect = ref<DOMRect | null>(null)

onMounted(() => {
    getRectOfElement()

    if (element.value) {
        observePosition(element.value, getRectOfElement)
        observeSize(element.value, getRectOfElement)
    }

    window.addEventListener('click', close)
    window.addEventListener('resize', getRectOfElement)
    document.getElementById('scroll-element')?.addEventListener('scroll', getRectOfElement)
})

onUnmounted(() => {
    window.removeEventListener('click', close)
    window.removeEventListener('resize', getRectOfElement)
    document.getElementById('scroll-element')?.removeEventListener('scroll', getRectOfElement)
})

function getRectOfElement() {
    const el = element.value
    const dropdownContent = dropdownRef.value

    if (!el || !dropdownContent) return

    let rect = el.getBoundingClientRect()
    elementRect.value = rect

    ySide.value = rect.top + rect.height + dropdownContent.offsetHeight + 10 < window.innerHeight ? 'top' : 'bottom'

    elementWidth.value = rect.width
    elementHeight.value = rect.height

    yProperty.value = rect.top
    xProperty.value = xSide.value === 'left' ? rect.left : rect.left - dropdownContent.offsetWidth + elementWidth.value
}

function open() {
    getRectOfElement()
    dropdownIsOpen.value = true
    emit('update:modelValue', true)
}

function close() {
    getRectOfElement()
    dropdownIsOpen.value = false
    emit('update:modelValue', false)
}

</script>

<template>
    <div
        ref="container"
        class="x-dropdown-container"
    >
        <div
            ref="element"
            @click.stop="open"
        >
            <slot />
        </div>
        <Teleport to="#portals">
            <div
                class="x-dropdown"
                :class="{
                    'visible': dropdownIsOpen,
                }"
            >
                <div
                    ref="dropdownRef"
                    class="x-dropdown-content"
                    :class="{
                        'visible': dropdownIsOpen,
                        'top': ySide === 'top',
                        'bottom': ySide === 'bottom',
                        'right': xSide === 'right',
                        'left': xSide === 'left'
                    }"
                    :style="{
                        '--element-height': `${elementHeight}px`,
                        'top': `${yProperty}px`,
                        'left': `${xProperty}px`
                    }"
                >
                    <slot name="dropdown" />
                </div>
            </div>
        </Teleport>
    </div>
</template>

<style scoped>
.x-dropdown-container {
    position: relative;
}

.x-dropdown {
    position: fixed;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    pointer-events: none;
    z-index: 1001;
}

.x-dropdown.visible {
    pointer-events: auto;
}

.x-dropdown-content {
    --element-height: 0px;

    position: absolute;
    z-index: 1000;
    border-radius: 10px;
    border: 1px solid var(--x-border-color);
    background-color: rgb(33, 33, 33, .87);
    backdrop-filter: blur(10px);
    box-shadow: 0 .25rem .5rem .125rem rgb(16, 16, 16, .612);
    opacity: 0;
    pointer-events: none;
    transition: transform .15s, opacity .15s;
}

.x-dropdown-content.visible {
    opacity: 1;
    pointer-events: auto;
}

/* top left */
.x-dropdown-content.bottom {
    transform-origin: bottom left;
    transform: scale(.85) translateY(calc(-100% - 10px));
}

.x-dropdown-content.bottom.visible {
    transform: scale(1) translateY(calc(-100% - 10px));
}

/* top right */
.x-dropdown-content.bottom.right {
    transform-origin: bottom right;
    transform: scale(.85) translateY(calc(-100% - 10px));
}

.x-dropdown-content.bottom.right.visible {
    transform: scale(1) translateY(calc(-100% - 10px));
}

/* top left */
.x-dropdown-content.top {
    transform-origin: top left;
    transform: scale(.85) translateY(calc(var(--element-height) + 10px));
}

.x-dropdown-content.top.visible {
    transform: scale(1) translateY(calc(var(--element-height) + 10px));
}

/* top right */
.x-dropdown-content.top.right {
    transform-origin: top right;
    transform: scale(.85) translateY(calc(var(--element-height) + 10px));
}

.x-dropdown-content.top.visible {
    transform: scale(1) translateY(calc(var(--element-height) + 10px));
}
</style>
