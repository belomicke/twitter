<script setup lang="ts">
import { ref } from 'vue'
import FirstStep from './FirstStep.vue'
import SecondStep from './SecondStep.vue'
import CreateAccountDTO from '@/features/auth/create-account/types/CreateAccountDTO'
import { useCreateAccessToken } from '@/features/auth/log-in/hook/useCreateAccessToken'
import XModal from '@/shared/ui/XModal/XModal.vue'

const step = ref(1)
const credentials = ref<CreateAccountDTO | undefined>(undefined)

const emit = defineEmits(['open', 'close'])

defineExpose({
    open,
    close,
})

const modal = ref<InstanceType<typeof XModal> | null>(null)

const { mutate: createAccessToken } = useCreateAccessToken()

function open() {
    modal.value?.open()
    emit('open')
}

function close() {
    emit('close')
    modal.value?.close()
    setTimeout(() => {
        step.value = 1
        credentials.value = undefined
    }, 150)
}

function firstStepSubmitHandler(data: CreateAccountDTO) {
    credentials.value = data
    step.value = 2
}

function secondStepSubmitHandler() {
    const data = {
        username: credentials.value?.username ?? '',
        password: credentials.value?.password ?? '',
    }

    createAccessToken(data)
}
</script>

<template>
    <x-modal
        ref="modal"
        centered
        @close="close"
    >
        <first-step
            v-if="step === 1"
            @submit="firstStepSubmitHandler"
            @close="close"
        />
        <second-step
            v-if="step === 2 && credentials"
            :credentials="credentials"
            @submit="secondStepSubmitHandler"
            @close="close"
        />
    </x-modal>
</template>
