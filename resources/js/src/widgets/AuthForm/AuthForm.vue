<script setup lang="ts">
import { ref } from 'vue'
import LogInForm from './ui/LogInForm.vue'
import SignUpForm from './ui/SignUpForm/SignUpForm.vue'
import XDivider from '@/shared/ui/XDivider/XDivider.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'

const activeModal = ref<'' | 'log-in' | 'sign-up'>('')

const logInForm = ref<InstanceType<typeof LogInForm> | null>(null)
const signUpForm = ref<InstanceType<typeof SignUpForm> | null>(null)

function openLogInForm() {
    activeModal.value = 'log-in'
    logInForm.value?.open()
}

function openSignUpForm() {
    activeModal.value = 'sign-up'
    signUpForm.value?.open()
}
</script>

<template>
    <div class="auth-form">
        <div class="container">
            <div class="title">
                <span class="text">Будь в курсе происходящего</span>
            </div>
            <div class="subtitle">
                <span class="text">Присоединяйся</span>
            </div>
            <div class="form">
                <x-button
                    type="primary"
                    rounded
                    size="large"
                    bold
                    block
                    @click="openLogInForm"
                >
                    Войти
                </x-button>
                <x-divider>
                    <div class="divider">
                        или
                    </div>
                </x-divider>
                <x-button
                    rounded
                    size="large"
                    bold
                    block
                    :active="activeModal === 'sign-up'"
                    @click="openSignUpForm"
                >
                    Зарегистрироваться
                </x-button>
            </div>
        </div>
    </div>
    <log-in-form
        ref="logInForm"
        @open="activeModal = 'log-in'"
        @close="activeModal = ''"
    />
    <sign-up-form
        ref="signUpForm"
        @open="activeModal = 'sign-up'"
        @close="activeModal = ''"
    />
</template>

<style scoped>
.auth-form {
    min-width: 45vw;
    padding: 16px;
}

.container {
    align-items: stretch;
    background-color: rgba(0, 0, 0, 0.00);
    border: 0 solid black;
    box-sizing: border-box;
    display: flex;
    flex-basis: auto;
    flex-direction: column;
    justify-content: center;
    height: 100%;
    flex-shrink: 0;
    list-style: none;
    margin: 0;
    min-height: 0;
    min-width: 0;
    position: relative;
    text-decoration: none;
    z-index: 0;
    max-width: 760px;
    width: 100%;
    padding: 20px;
}

.title {
    margin-bottom: 48px;
    font-weight: 700;
    min-width: 0;
    word-wrap: break-word;
    font-size: 64px;
    letter-spacing: -1.2px;
    line-height: 84px;
    color: rgb(231, 233, 234);
    text-overflow: unset;
}

.subtitle {
    color: rgb(231, 233, 234);
    margin-bottom: 32px;
    line-height: 36px;
    word-wrap: break-word;
    min-width: 0;
    font-weight: 700;
    font-size: 31px;
}

.text {
    min-width: 0;
    font-family: inherit;
    word-wrap: break-word;
    text-overflow: unset;
    user-select: none;
}

.form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
}

.divider {
    text-transform: uppercase;
    color: rgb(231, 233, 234);
    line-height: 20px;
    font-size: 15px;
    font-weight: 400;
    user-select: none;
}
</style>
