<script setup lang="ts">
import { ref } from 'vue'
import XInput from '@/shared/ui/XInput'
import { useCheckUsername } from '@/shared/api/hook/account/useCheckUsername'
import { checkUsernameIsValid } from '@/shared/helpers/checkUsernameIsValid'
import _ from 'lodash'

const usernameIsLoading = ref(false)
const usernameErrorMessage = ref('')
const checkedUsernames = ref([] as { username: string, status: boolean }[])

const {
    username,
    usernameIsValid
} = defineProps({
    username: {
        type: String,
        required: true
    },
    usernameIsValid: {
        type: Boolean,
        required: true
    }
})

const emit = defineEmits(['update:username', 'update:usernameIsValid'])

const { mutate } = useCheckUsername()

const debouncedFunction = _.debounce((newValue: string) => {
    mutate(newValue, {
        onSuccess: (data) => {
            const status = data.data.data.exists

            checkedUsernames.value.push({
                username: newValue,
                status
            })

            if (status) {
                usernameErrorMessage.value = 'Имя пользователя уже занято.'
                emit('update:usernameIsValid', false)
            } else {
                usernameErrorMessage.value = ''
                emit('update:usernameIsValid', true)
            }
        }
    })

    usernameIsLoading.value = false
}, 500)

const inputHandler = (newValue: string) => {
    emit('update:username', newValue)
    emit('update:usernameIsValid', undefined)

    if (!newValue.length || newValue.length < 4) {
        usernameErrorMessage.value = ''
        emit('update:usernameIsValid', false)
        return
    }

    const isValid = checkUsernameIsValid(newValue)

    if (!isValid) {
        usernameErrorMessage.value = 'Имя может содержать только латинские буквы и цифры'
        emit('update:usernameIsValid', false)
        return
    } else {
        emit('update:usernameIsValid', false)
        usernameErrorMessage.value = ''
    }

    const entity = checkedUsernames.value.find(item => item.username === newValue)

    if (entity) {
        if (entity.status) {
            usernameErrorMessage.value = 'Имя пользователя уже занято.'
            emit('update:usernameIsValid', false)
            return
        } else {
            emit('update:usernameIsValid', true)
            return
        }
    }

    usernameIsLoading.value = true

    debouncedFunction(newValue)
}
</script>

<template>
    <x-input
        :model-value="username"
        @update:model-value="inputHandler"
        :loading="usernameIsLoading"
        :is-valid="usernameIsValid && !usernameIsLoading"
        :error-message="usernameErrorMessage"
        maxlength="32"
        minlength="4"
        show-word-limit
        placeholder="Имя пользователя"
    />
</template>
