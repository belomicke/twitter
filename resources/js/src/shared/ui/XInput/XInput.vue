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
            <div
                class="password"
                v-if="password" @click="passwordIsVisible = !passwordIsVisible"
            >
                <x-icon icon="eye" v-if="!passwordIsVisible"/>
                <x-icon icon="crossed-out-eye" v-else/>
            </div>
            <div
                class="input-word-limit"
                v-if="showWordLimit && $attrs.maxlength"
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
@import './XInput.css';
</style>
