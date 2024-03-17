import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useSendVerificationCode = () => {
    return useMutation({
        mutationKey: ['create-verification-code'],
        mutationFn: async (email: string) => {
            return await api.auth.sendVerificationCode(email)
        }
    })
}
