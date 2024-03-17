<script setup lang="ts">
import { computed, ref } from 'vue'
import { useCreateAccessToken } from '../hook/useCreateAccessToken'
import AuthFormFooter from '@/entities/Auth/ui/AuthFormFooter.vue'
import XModal from '@/shared/ui/XModal/XModal.vue'
import XInput from '@/shared/ui/XInput'
import XButton from '@/shared/ui/XButton/XButton.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import XModalContainer from '@/shared/ui/modal/XModalContainer/XModalContainer.vue'
import { useAppNotificationStore } from '@/entities/App/store/AppNotificationStore'

const username = ref<string>('')
const password = ref<string>('')

const isLoading = ref<boolean>(false)

const modal = ref<InstanceType<typeof XModal> | null>(null)

const wrongCredentials = ref<{ username: string, password: string }[]>([])

const emit = defineEmits(['open', 'close'])

defineExpose({
    open,
    close
})

const appNotificationStore = useAppNotificationStore()

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
            }
        },
        onError() {
            isLoading.value = false
            wrongCredentials.value.push(data)
        }
    })
}
</script>

<template>
    <x-modal
        ref="modal"
        centered
        @close="close"
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
                                v-model="username"
                                placeholder="Имя пользователя"
                                name="username"
                            />
                            <x-input
                                v-model="password"
                                placeholder="Пароль"
                                password
                                name="password"
                            />
                        </div>
                    </div>
                </div>
                <auth-form-footer>
                    <x-button
                        type="info"
                        size="large"
                        :disabled="!formIsValid || isLoading"
                        bold
                        rounded
                        block
                        @click="submit"
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
