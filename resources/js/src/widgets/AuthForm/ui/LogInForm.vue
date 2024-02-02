<script setup lang="ts">
import { computed, ref } from 'vue'
import XModalContainer from '@/shared/ui/modal/XModalContainer/XModalContainer.vue'
import { useCreateAccessToken } from '@/shared/api/hook/auth/useCreateAccessToken'
import XModal from '@/shared/ui/XModal/XModal.vue'
import XInput from '@/shared/ui/XInput'
import XButton from '@/shared/ui/XButton/XButton.vue'
import XAlert from '@/shared/ui/XAlert/XAlert.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import AuthFormFooter from '@/entities/Auth/ui/AuthFormFooter.vue'

const username = ref<string>('')
const password = ref<string>('')

const isLoading = ref<boolean>(false)

const alert = ref<InstanceType<typeof XAlert> | null>(null)

const modal = ref<InstanceType<typeof XModal> | null>(null)

const wrongCredentials = ref<{ username: string, password: string }[]>([])

const emit = defineEmits(['open', 'close'])

defineExpose({
    open,
    close
})

const formIsValid = computed(() => {
    if (username.value.length < 4 || username.value.length > 32) return false
    if (password.value.length < 8) return false

    return !wrongCredentials.value.find(item => {
        const passwordAreEqual = item.password === password.value
        const usernameAreEqual = item.username === username.value

        return passwordAreEqual && usernameAreEqual
    })
})

const { mutate: createAccessToken } = useCreateAccessToken()

function open() {
    modal.value?.open()
    emit('open')
}

function close() {
    emit('close')
    modal.value?.close()
}

function submit() {
    const data = {
        username: username.value,
        password: password.value
    }

    isLoading.value = true
    createAccessToken(data, {
        onSuccess: (data) => {
            if (!data.data.success) {
                isLoading.value = false
                alert.value?.open()
            }
        },
        onError() {
            isLoading.value = false
            alert.value?.open()
            wrongCredentials.value.push(data)

            setTimeout(() => {
                alert.value?.close()
            }, 2500)
        },
    })
}
</script>

<template>
    <x-modal
        @close="close"
        centered
        ref="modal"
    >
        <x-modal-container @close="close">
            <template #header>
                <div class="modal-header-title">
                    Вход
                </div>
            </template>
            <template #default>
                <div class="container">
                    <div class="body">
                        <div class="logo-container">
                            <x-icon
                                icon="logo"
                                :size="120"
                            />
                        </div>
                        <div class="form">
                            <x-input
                                placeholder="Имя пользователя"
                                v-model="username"
                                name="username"
                            />
                            <x-input
                                placeholder="Пароль"
                                v-model="password"
                                password
                                name="password"
                            />
                            <x-alert
                                title="Неверное имя пользователя или пароль"
                                type="error"
                                ref="alert"
                            />
                        </div>
                    </div>
                </div>
                <auth-form-footer>
                    <x-button
                        type="info"
                        size="large"
                        :disabled="!formIsValid || isLoading"
                        @click="submit"
                        bold
                        rounded
                        block
                    >
                        Войти
                    </x-button>
                </auth-form-footer>
            </template>
        </x-modal-container>
    </x-modal>
</template>

<style scoped>
.modal-header-title {
    color: rgb(231, 233, 234);
    word-wrap: break-word;
    max-width: 100%;
    font-weight: var(--x-font-weight-bold);
    font-size: 21px;
    margin-left: 20px;
}

.container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 40px 80px 0;
    height: 100%;
    overflow: auto;
}

.body {
    display: flex;
    flex-direction: column;
    grid-gap: 30px;
    height: 100%;
    width: 100%;
}

.form {
    display: flex;
    flex-direction: column;
    grid-gap: 30px;
}

.logo-container {
    margin: 0 auto;
    padding-top: 20px;
}
</style>
