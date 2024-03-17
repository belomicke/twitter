import { useMutation } from '@tanstack/vue-query'
import CreateAccessTokenDTO from '../types/CreateAccessTokenDTO'
import { api } from '@/shared/api/methods'
import { useAppNotificationStore } from '@/entities/App/store/AppNotificationStore'

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
        onError() {
            const appNotificationStore = useAppNotificationStore()
            appNotificationStore.addNotification('Неверный логин или пароль', 'danger')
        }
    })
}
