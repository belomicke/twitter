<script setup lang="ts">
import { nextTick, onMounted, ref, watch } from 'vue'

const { modelValue } = defineProps({
    modelValue: {
        type: String,
        required: true
    },
    placeholder: {
        type: String,
        required: false,
        default: ''
    },
    showWordLimit: {
        type: Boolean,
        required: false,
        default: false
    },
    noWrapper: {
        type: Boolean,
        required: false,
        default: false
    }
})

const value = ref<string>(modelValue)

const emit = defineEmits(['update:modelValue'])

const textarea = ref<HTMLTextAreaElement | null>(null)

function textareaHandler(e: InputEvent) {
    const target = e.target as HTMLTextAreaElement

    if (target) {
        value.value = target.value
        emit('update:modelValue', target.value)
    }
}

function containerClickHandler() {
    textarea.value?.focus()
}

function resize() {
    if (!textarea.value) return

    textarea.value.style.height = 'auto'

    nextTick(() => {
        if (!textarea.value) return

        textarea.value.style.height = textarea.value.scrollHeight + 'px'
    })
}

watch(value, resize)
onMounted(() => resize())
</script>

<template>
    <div
        v-if="!noWrapper"
        class="wrapper"
    >
        <div
            class="container"
            :class="{
                'is-not-empty': modelValue.length
            }"
            @click="containerClickHandler"
        >
            <div class="placeholder-container">
                <span class="placeholder">{{ placeholder }}</span>
            </div>
            <div class="textarea-wrapper">
                <div class="textarea-container">
                    <textarea
                        v-bind="$attrs"
                        ref="textarea"
                        class="textarea"
                        :value="modelValue"
                        :maxRows="160"
                        :minRows="1"
                        @input="textareaHandler"
                    />
                </div>
            </div>
            <div
                v-if="showWordLimit && $attrs.maxlength && modelValue"
                class="textarea-word-limit"
            >
                {{ modelValue.length }} / {{ $attrs.maxlength }}
            </div>
        </div>
    </div>
    <textarea
        v-else
        v-bind="$attrs"
        ref="textarea"
        class="textarea"
        :value="modelValue"
        :maxRows="160"
        :minRows="1"
        @input="textareaHandler"
    />
</template>

<style scoped>
.wrapper {
    --border-color: rgb(60, 60, 60);
    --border-hover-color: var(--x-color-primary-opacity-7);
    --border-active-color: var(--x-color-primary);

    --textarea-placeholder-color: rgb(120, 120, 120);
    --textarea-placeholder-hover-color: var(--x-color-primary-opacity-7);

    --textarea-text-color: rgb(231, 233, 234);
}

.wrapper {
    position: relative;
    border: 1px solid var(--border-color);
    border-radius: var(--x-border-radius-base);
    transition: border-color .15s;
}

.wrapper:hover {
    border-color: var(--border-hover-color);
}

.wrapper:focus-within,
.wrapper:hover:focus-within {
    border-color: var(--x-color-primary);
}

/* container */
.container {
    position: relative;
    cursor: text;
    overflow: hidden;
    transition: .15s;
}

/* end container */

/* textarea */
.textarea-wrapper {
    display: flex;
    flex-grow: 1;
    flex-shrink: 1;
    margin-top: 16px;
    padding: 12px 8px 8px;
    overflow: hidden;
}

.textarea-container {
    display: flex;
    align-items: center;
    color: var(--textarea-text-color);
    word-wrap: break-word;
    min-width: 0;
    font-weight: 400;
    width: 100%;
    font-size: 17px;
    line-height: 24px;
}

.textarea {
    padding: 0;
    border: 0;
    width: 100%;
    height: auto;
    outline: 0;
    text-align: left;
    appearance: none;
    resize: none;
    color: inherit;
    font-size: inherit;
    background-color: rgba(0, 0, 0, 0);
    word-wrap: break-word;
    white-space: pre-wrap;
    overflow: auto;
}

/* end textarea */

/* placeholder */
.placeholder-container {
    display: flex;
    justify-content: space-between;
    position: absolute;
    pointer-events: none;
    width: 100%;
    height: 100%;
}

.placeholder {
    color: var(--textarea-placeholder-color);
    overflow: hidden;
    padding: 16px 8px 0;
    line-height: 24px;
    font-size: 17px;
    font-weight: var(--x-font-weight-normal);
    white-space: nowrap;
    min-width: 0;
    max-width: 100%;
    word-wrap: break-word;
    transition: color .15s, font-size .15s, padding-top .15s;
}

.wrapper:focus-within .placeholder,
.container.is-not-empty .placeholder {
    font-size: small;
    line-height: 16px;
    padding-top: 8px;
}

.wrapper:hover .placeholder {
    color: var(--textarea-placeholder-hover-color);
}

.wrapper:focus-within .placeholder {
    color: var(--x-color-primary);
}

/* end placeholder */

.textarea-word-limit {
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 12px;
    color: rgb(113, 118, 123);
    opacity: 0;
    transition: color .15s, opacity .15s;
}

.wrapper:focus-within .textarea-word-limit {
    color: var(--x-color-primary);
    opacity: 1;
}
</style>
