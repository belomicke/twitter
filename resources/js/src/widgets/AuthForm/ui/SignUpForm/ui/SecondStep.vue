<script setup lang="ts">
import { computed, PropType, ref } from 'vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import XInput from '@/shared/ui/XInput'
import XModalContainer from '@/shared/ui/modal/XModalContainer/XModalContainer.vue'
import CreateAccountDTO from '@/shared/api/types/DTO/auth/CreateAccountDTO'
import { useCreateAccount } from '@/shared/api/hook/auth/useCreateAccount'
import XAlert from '@/shared/ui/XAlert/XAlert.vue'
import AuthFormFooter from '@/entities/Auth/ui/AuthFormFooter.vue'

const { credentials } = defineProps({
    credentials: {
        type: Object as PropType<CreateAccountDTO>,
        required: true
    }
})

const emit = defineEmits(['submit', 'close'])

const isLoading = ref<boolean>(false)
const code = ref<string>('')

const alert = ref<InstanceType<typeof XAlert> | null>(null)

const invalidCodes = ref<string[]>([])

const { mutate: createAccount } = useCreateAccount()

const formIsValid = computed(() => {
    const codeIsInvalid = invalidCodes.value.find(item => item === code.value)

    return code.value.length === 6 && !isLoading.value && !codeIsInvalid
})

function submit() {
    isLoading.value = true
    const data: CreateAccountDTO = {
        ...credentials,
        code: Number(code.value)
    }

    createAccount(data, {
        onSuccess: () => {
            emit('submit')
            isLoading.value = false
        },
        onError: () => {
            invalidCodes.value.push(code.value)
            alert.value?.open()

            setTimeout(() => {
                alert.value?.close()
            }, 5000)

            isLoading.value = false
        }
    })
}
</script>

<template>
    <x-modal-container @close="$emit('close')">
        <template #header>
            <div class="modal-header-title">Подтвердите учетную запись</div>
        </template>
        <template #default>
            <div class="container">
                <div class="body">
                    <div class="title">Мы отправили вам код</div>
                    <div class="body-info">
                        Введите код в расположенном ниже поле для подтверждения {{
                            credentials ? credentials.email : ''
                        }}.
                    </div>
                    <div class="form">
                        <x-input
                            v-model="code"
                            placeholder="Проверочный код"
                        />
                        <x-alert
                            title="Неверный проверочный код"
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
                    :disabled="!formIsValid"
                    @click="submit"
                    bold
                    rounded
                    block
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
    padding: 0 80px;
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

.title {
    color: rgb(231, 233, 234);
    line-height: 36px;
    font-weight: var(--x-font-weight-bold);
    font-size: 31px;
    margin: 20px 0;
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
    grid-gap: 15px;
}

.body-info {
    font-weight: var(--x-font-weight-normal);
    font-size: 14px;
    line-height: 16px;
    word-wrap: break-word;
    margin-bottom: 15px;
    color: rgb(113, 118, 123);
}
</style>
