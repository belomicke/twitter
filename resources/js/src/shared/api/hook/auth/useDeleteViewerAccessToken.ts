import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useDeleteViewerAccessToken = () => {
    return useMutation({
        mutationKey: ['delete-viewer-access-token'],
        mutationFn: async () => {
            return await api.auth.deleteViewerAccessToken()
        },
        onSuccess() {
            localStorage.removeItem('token')
            window.location.reload()
        },
    })
}
