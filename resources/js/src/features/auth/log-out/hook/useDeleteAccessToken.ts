import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useDeleteAccessToken = () => {
    return useMutation({
        mutationKey: ['delete-access-token'],
        mutationFn: async () => {
            return await api.auth.deleteViewerAccessToken()
        },
        onSuccess() {
            localStorage.removeItem('token')
            window.location.reload()
        },
    })
}
