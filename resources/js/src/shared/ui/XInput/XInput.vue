<script setup lang="ts">
import { ref } from 'vue'
import XSpinner from '@/shared/ui/XSpinner/XSpinner.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

defineProps({
    modelValue: {
        type: String,
        required: true
    },
    placeholder: {
        type: String,
        required: true
    },
    loading: {
        type: Boolean,
        required: false,
        default: false
    },
    isValid: {
        type: Boolean,
        required: false,
        default: false
    },
    showWordLimit: {
        type: Boolean,
        required: false,
        default: false
    },
    errorMessage: {
        type: String,
        required: false,
        default: ''
    },
    password: {
        type: Boolean,
        required: false,
        default: false
    }
})

const emit = defineEmits(['update:modelValue'])

const passwordIsVisible = ref<boolean>(false)

const input = ref<HTMLInputElement | null>(null)

function inputHandler(e: InputEvent) {
    const target = e.target as HTMLInputElement

    if (target) {
        emit('update:modelValue', target.value)
    }
}

function containerClickHandler() {
    input.value?.focus()
}
</script>

<template>
    <div
        class="wrapper"
        :class="{
            'error': errorMessage.length > 0
        }"
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
            <div class="input-wrapper">
                <div class="input-container">
                    <input
                        class="input"
                        :value="modelValue"
                        @input="inputHandler"
                        v-bind="$attrs"
                        :type="password && !passwordIsVisible ? 'password' : 'text'"
                        ref="input"
                    />
                </div>
            </div>
            <div
                class="spinner"
                v-if="loading"
            >
                <x-spinner :size="20"/>
            </div>
            <div
                class="is-valid"
                v-if="isValid"
            >
                <x-icon icon="check"/>
            </div>
            <div class="password" v-if="password" @click="passwordIsVisible = !passwordIsVisible">
                <x-icon icon="eye" v-if="!passwordIsVisible"/>
                <x-icon icon="crossed-out-eye" v-else/>
            </div>
            <div
                class="input-word-limit"
                v-if="showWordLimit"
            >
                {{ modelValue.length }} / {{ $attrs.maxlength }}
            </div>
        </div>
        <div class="error-message" v-if="errorMessage.length">
            {{ errorMessage }}
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    --border-color: rgb(60, 60, 60);
    --border-hover-color: rgb(120, 120, 120);
    --border-active-color: var(--x-color-primary);

    --input-placeholder-color: rgb(120, 120, 120);
    --input-placeholder-hover-color: rgb(160, 160, 160);

    --input-text-color: rgb(231, 233, 234);
}

.wrapper {
    position: relative;
    border: 1px solid var(--border-color);
    border-radius: var(--x-border-radius-base);
    transition: border-color .15s;
}

.wrapper.error {
    border-color: var(--x-color-danger);
}

.wrapper.error:hover {
    border-color: var(--x-color-danger);
}

.wrapper.error:focus-within,
.wrapper.error:hover:focus-within {
    border-color: var(--x-color-danger);
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

/* input */
.input-wrapper {
    display: flex;
    flex-grow: 1;
    flex-shrink: 1;
    margin-top: 16px;
    padding: 12px 8px 8px;
    overflow: hidden;
}

.input-container {
    display: flex;
    align-items: center;
    color: var(--input-text-color);
    word-wrap: break-word;
    min-width: 0;
    font-weight: 400;
    width: 100%;
    font-size: 17px;
    line-height: 24px;
}

.input {
    padding: 0;
    border: 0;
    width: 100%;
    outline: 0;
    text-align: left;
    appearance: none;
    resize: none;
    color: inherit;
    font-size: inherit;
    background-color: rgba(0, 0, 0, 0);
    word-wrap: break-word;
    white-space: pre-wrap;
}

.input:-webkit-autofill, .input:focus:-webkit-autofill {
    box-shadow: inset 0 0 0 10rem rgb(0, 0, 0);
    -webkit-text-fill-color: var(--input-text-color);
}

/* end input */

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
    color: var(--input-placeholder-color);
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

.wrapper.error .placeholder {
    color: var(--x-color-danger);
}

.wrapper.error:hover .placeholder {
    color: var(--x-color-danger);
}

.wrapper.error:focus-within .placeholder {
    color: var(--x-color-danger);
}

.wrapper:focus-within .placeholder,
.container.is-not-empty .placeholder {
    font-size: small;
    line-height: 16px;
    padding-top: 8px;
}

.wrapper:hover .placeholder {
    color: var(--input-placeholder-hover-color);
}

.wrapper:focus-within .placeholder {
    color: var(--x-color-primary);
}

/* end placeholder */

.input-word-limit {
    position: absolute;
    top: 8px;
    right: 8px;
    font-size: 12px;
    color: rgb(113, 118, 123);
    opacity: 0;
    transition: color .15s, opacity .15s;
}

.wrapper.error .input-word-limit,
.wrapper.error:focus-within .input-word-limit {
    color: var(--x-color-danger);
}

.wrapper:focus-within .input-word-limit {
    color: var(--x-color-primary);
    opacity: 1;
}

.spinner, .is-valid {
    height: 20px;
    width: 20px;
    position: absolute;
    right: 8px;
    bottom: 8px;
}

.error-message {
    position: absolute;
    transform: translateY(5px);
    color: var(--x-color-danger);
    font-size: 13px;
    font-weight: 400;
}

.password {
    position: absolute;
    right: 8px;
    bottom: 8px;
    width: 20px;
    height: 20px;
    cursor: pointer;
}
</style>
