import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { useViewerStore } from '@/entities/Viewer/store'

export const useDeleteProfileBanner = () => {
    return useMutation({
        mutationKey: ['delete-profile-banner'],
        mutationFn: async () => {
            return await api.account.profile_banner.remove()
        },
        onSuccess() {
            const viewerStore = useViewerStore()

            viewerStore.changeProfileBanner({
                default: '',
                large: '',
            })
        },
    })
}
