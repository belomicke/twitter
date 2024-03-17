import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useCheckUsername = () => {
    return useMutation({
        mutationKey: ['username-exists'],
        mutationFn: async (username: string) => {
            return await api.account.checkUsername(username)
        }
    })
}
