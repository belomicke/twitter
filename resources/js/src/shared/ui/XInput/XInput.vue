<script setup lang="ts">
import { ref } from 'vue'
import XSpinner from '@/shared/ui/XSpinner/XSpinner.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: true,
    },
    loading: {
        type: Boolean,
        required: false,
        default: false,
    },
    isValid: {
        type: Boolean,
        required: false,
        default: false,
    },
    showWordLimit: {
        type: Boolean,
        required: false,
        default: false,
    },
    errorMessage: {
        type: String,
        required: false,
        default: '',
    },
    password: {
        type: Boolean,
        required: false,
        default: false,
    },
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
                        v-bind="$attrs"
                        ref="input"
                        class="input"
                        :value="modelValue"
                        :type="password && !passwordIsVisible ? 'password' : 'text'"
                        @input="inputHandler"
                    >
                </div>
            </div>
            <div
                v-if="loading"
                class="spinner"
            >
                <x-spinner :size="20" />
            </div>
            <div
                v-if="isValid"
                class="is-valid"
            >
                <x-icon icon="check" />
            </div>
            <div
                v-if="password"
                class="password"
                @click="passwordIsVisible = !passwordIsVisible"
            >
                <x-icon
                    v-if="!passwordIsVisible"
                    icon="eye"
                />
                <x-icon
                    v-else
                    icon="crossed-out-eye"
                />
            </div>
            <div
                v-if="showWordLimit && $attrs.maxlength"
                class="input-word-limit"
            >
                {{ modelValue.length }} / {{ $attrs.maxlength }}
            </div>
        </div>
        <div
            v-if="errorMessage.length"
            class="error-message"
        >
            {{ errorMessage }}
        </div>
    </div>
</template>

<style scoped>
@import './XInput.css';
</style>
