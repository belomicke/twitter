<script setup lang="ts">
import { onMounted, onUnmounted, PropType, ref, watch } from 'vue'
import { observePosition } from '@/shared/helpers/observePositionOfElement'
import { observeSize } from '@/shared/helpers/observeSizeOfElement'

const props = defineProps({
    modelValue: {
        type: Boolean,
        required: false
    },
    xSide: {
        type: String as PropType<'left' | 'right' | 'center'>,
        required: false,
        default: 'center'
    },
    ySide: {
        type: String as PropType<'top' | 'bottom' | 'center'>,
        required: false,
        default: 'center'
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

const ySide = ref<'top' | 'bottom' | 'center'>(props.ySide)
const xSide = ref<'left' | 'right' | 'center'>(props.xSide)

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

watch(() => props.xSide, () => {
    xSide.value = props.xSide
    getRectOfElement()
})

watch(() => props.ySide, () => {
    ySide.value = props.ySide
    getRectOfElement()
})

function getRectOfElement() {
    const el = element.value
    const dropdownContent = dropdownRef.value

    if (!el || !dropdownContent) return

    let rect = el.getBoundingClientRect()
    elementRect.value = rect

    elementWidth.value = rect.width
    elementHeight.value = rect.height

    if (props.ySide === 'center' && dropdownContent.offsetHeight < window.innerHeight) {
        yProperty.value = rect.bottom
    } else {
        ySide.value = rect.top + rect.height + 10 + dropdownContent.offsetHeight > window.innerHeight ? 'top' : 'bottom'

        yProperty.value = ySide.value === 'bottom' ? rect.bottom + 10 : rect.top - dropdownContent.offsetHeight - 10
    }

    if (props.xSide === 'center' && dropdownContent.offsetHeight < window.innerWidth) {
        xProperty.value = rect.left
    } else {
        xSide.value = rect.right - dropdownContent.offsetWidth < 0 ? 'right' : 'left'

        xProperty.value = xSide.value === 'left' ? rect.left - dropdownContent.offsetWidth + elementWidth.value : rect.left
    }
}

function open() {
    getRectOfElement()
    dropdownIsOpen.value = true
    emit('update:modelValue', true)
}

function close() {
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
                    'pointer-events': dropdownIsOpen ? 'all' : 'none'
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

.x-dropdown-content {
    transform: scale(.85);
}

.x-dropdown-content.visible {
    opacity: 1;
    pointer-events: auto;
    transform: scale(1);
}

/* bottom */
.x-dropdown-content.bottom {
    transform-origin: top;
}

/* top */
.x-dropdown-content.top {
    transform-origin: bottom;
}

/* bottom left */
.x-dropdown-content.bottom.left {
    transform-origin: top right;
}

/* bottom right */
.x-dropdown-content.bottom.right {
    transform-origin: top left;
}

/* top left */
.x-dropdown-content.top.left {
    transform-origin: bottom right;
}

/* top right */
.x-dropdown-content.top.right {
    transform-origin: bottom left;
}
</style>
