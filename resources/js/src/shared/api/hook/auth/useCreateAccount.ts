import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import CreateAccountDTO from '@/shared/api/types/DTO/auth/CreateAccountDTO'

export const useCreateAccount = () => {
    return useMutation({
        mutationKey: ['create-account'],
        mutationFn: async (data: CreateAccountDTO) => {
            return await api.auth.createAccount(data)
        }
    })
}
