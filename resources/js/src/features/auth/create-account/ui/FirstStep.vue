<script setup lang="ts">
import { computed, ref } from 'vue'
import { useSendVerificationCode } from '../hook/useSendVerificationCode'
import CreateAccountDTO from '../types/CreateAccountDTO'
import { EmailInput } from '../features/email-input'
import { UsernameInput } from '../features/username-input'
import BirthForm from '@/entities/Auth/ui/BirthForm.vue'
import AuthFormFooter from '@/entities/Auth/ui/AuthFormFooter.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import XInput from '@/shared/ui/XInput'
import XModalContainer from '@/shared/ui/modal/XModalContainer/XModalContainer.vue'

const username = ref<string>('')
const email = ref<string>('')
const password = ref<string>('')
const selectedMonth = ref<number>(0)
const selectedYear = ref<number>(0)
const selectedDay = ref<number>(0)
const isLoading = ref<boolean>(false)
const emailIsValid = ref<boolean>(false)
const usernameIsValid = ref<boolean>(false)

const emit = defineEmits(['submit', 'close'])

const formIsValid = computed(() => {
    if (!username.value.length) return false
    if (!email.value.length) return false
    if (!selectedYear.value) return false
    if (!selectedMonth.value) return false

    return selectedDay.value
})

const { mutate: sendVerificationCode } = useSendVerificationCode()

function submit() {
    isLoading.value = true

    const data: CreateAccountDTO = {
        username: username.value,
        email: email.value,
        password: password.value,
        code: '',
        birth: `${selectedYear.value}-${selectedMonth.value}-${selectedDay.value}`
    }

    sendVerificationCode(email.value, {
        onSuccess: () => {
            isLoading.value = false
            emit('submit', data)
        }
    })
}

function close() {
    username.value = ''
    email.value = ''
    password.value = ''
    selectedYear.value = 0
    selectedMonth.value = 0
    selectedDay.value = 0
    emit('close')
}
</script>

<template>
    <x-modal-container
        :loading="isLoading"
        @close="close"
    >
        <template #header>
            <div class="modal-header-title">
                Создайте учетную запись
            </div>
        </template>
        <template #default>
            <div class="container">
                <div class="body">
                    <div class="form">
                        <username-input
                            v-model:username="username"
                            v-model:username-is-valid="usernameIsValid"
                        />
                        <email-input
                            v-model:email="email"
                            v-model:email-is-valid="emailIsValid"
                        />
                        <x-input
                            v-model="password"
                            placeholder="Пароль"
                            password
                        />
                    </div>
                    <birth-form
                        v-model:year="selectedYear"
                        v-model:month="selectedMonth"
                        v-model:day="selectedDay"
                    />
                </div>
            </div>
            <auth-form-footer>
                <x-button
                    type="info"
                    size="large"
                    :disabled="!formIsValid"
                    bold
                    rounded
                    block
                    @click="submit"
                >
                    Далее
                </x-button>
            </auth-form-footer>
        </template>
    </x-modal-container>
</template>

<style scoped>
.container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 40px 80px 0;
    height: 100%;
    overflow: auto;
}

.modal-header-title {
    color: rgb(231, 233, 234);
    word-wrap: break-word;
    max-width: 100%;
    font-weight: var(--x-font-weight-bold);
    font-size: 20px;
    line-height: 24px;
    padding-bottom: 2px;
    padding-top: 2px;
    margin-left: 20px;
}

.body {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
}

.form {
    display: flex;
    flex-direction: column;
    grid-gap: 30px;
}
</style>
