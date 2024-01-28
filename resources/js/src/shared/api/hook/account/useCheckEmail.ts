import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useCheckEmail = () => {
    return useMutation({
        mutationKey: ['email-exists'],
        mutationFn: async (email: string) => {
            return await api.account.checkEmail(email)
        }
    })
}
