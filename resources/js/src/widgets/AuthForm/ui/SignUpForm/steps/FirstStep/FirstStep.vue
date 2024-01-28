<script setup lang="ts">
import { computed, ref } from 'vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import XInput from '@/shared/ui/XInput/XInput.vue'
import CreateAccountDTO from '@/shared/api/types/DTO/auth/CreateAccountDTO'
import XModalContainer from '@/shared/ui/modal/XModalContainer/XModalContainer.vue'
import BirthForm from '@/widgets/AuthForm/ui/SignUpForm/steps/FirstStep/ui/BirthForm.vue'
import EmailInput from '@/features/account/EmailInput/EmailInput.vue'
import { useSendVerificationCode } from '@/shared/api/hook/auth/useSendVerificationCode'
import UsernameInput from '@/features/account/UsernameInput/UsernameInput.vue'

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
        verification_code: 0,
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
    <x-modal-container @close="close" :loading="isLoading">
        <template #header>
            <div class="modal-header-title">Создайте учетную запись</div>
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
            <div class="footer">
                <x-button
                    type="info"
                    size="large"
                    :disabled="!formIsValid"
                    @click="submit"
                    bold
                    rounded
                    block
                >
                    Далее
                </x-button>
            </div>
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

.footer {
    padding: 24px 80px;
    box-shadow: rgba(255, 255, 255, 0.2) 0 0 7px, rgba(255, 255, 255, 0.15) 0 1px 3px 1px;
}
</style>
