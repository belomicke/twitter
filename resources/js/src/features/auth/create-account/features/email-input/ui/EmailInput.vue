<script setup lang="ts">
import { ref, watch } from 'vue'
import _ from 'lodash'
import { useCheckEmail } from '../hook/useCheckEmail'
import { checkEmailIsValid } from '../helpers/checkEmailIsValid'
import XInput from '@/shared/ui/XInput'

const value = ref('')
const emailIsLoading = ref(false)
const emailErrorMessage = ref('')
const checkedEmails = ref([] as { email: string, status: boolean }[])

defineProps({
    email: {
        type: String,
        required: true,
    },
    emailIsValid: {
        type: Boolean,
        required: true,
    },
})

const emit = defineEmits(['update:email', 'update:emailIsValid'])

const { mutate } = useCheckEmail()

const debouncedFunction = _.debounce((newValue: string) => {
    mutate(newValue, {
        onSuccess: (data) => {
            const status = data.data.data.exists

            checkedEmails.value.push({
                email: newValue,
                status,
            })

            if (status) {
                emailErrorMessage.value = 'Адрес электронной почты уже занят.'
                emit('update:emailIsValid', false)
            } else {
                emailErrorMessage.value = ''
                emit('update:emailIsValid', true)
            }
        },
    })

    emailIsLoading.value = false
}, 500)

watch(value, (newValue) => {
    emit('update:email', newValue)

    if (!newValue.length) {
        emailErrorMessage.value = ''
        emit('update:emailIsValid', false)
        return
    }

    const isValid = checkEmailIsValid(newValue)

    if (!isValid) {
        emailErrorMessage.value = 'Введите правильный адрес электронной почты.'
        emit('update:emailIsValid', false)
        return
    } else {
        emailErrorMessage.value = ''
    }

    const entity = checkedEmails.value.find(item => item.email === newValue)

    if (entity) {
        if (entity.status) {
            emit('update:emailIsValid', true)
            return
        } else {
            emailErrorMessage.value = 'Адрес электронной почты уже занят.'
            emit('update:emailIsValid', false)
            return
        }
    }

    emailIsLoading.value = true

    debouncedFunction(newValue)
})
</script>

<template>
    <x-input
        v-model="value"
        :is-valid="emailIsValid"
        :loading="emailIsLoading"
        :error-message="emailErrorMessage"
        placeholder="Адрес электронной почты"
    />
</template>
