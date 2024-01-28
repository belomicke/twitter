import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import CreateAccessTokenDTO from '@/shared/api/types/DTO/auth/CreateAccessTokenDTO'

export const useCreateAccessToken = () => {
    return useMutation({
        mutationKey: ['create-access-token'],
        mutationFn: async (data: CreateAccessTokenDTO) => {
            return await api.auth.createAccessToken(data)
        },
        onSuccess(res) {
            const data = res.data

            if (data.success) {
                localStorage.setItem('token', data.data.token)
                window.location.reload()
            }
        },
    })
}
