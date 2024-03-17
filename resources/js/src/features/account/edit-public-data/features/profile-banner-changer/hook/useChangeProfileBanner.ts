import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { useViewerStore } from '@/entities/Viewer/store'

export const useChangeProfileBanner = () => {
    return useMutation({
        mutationKey: ['change-profile-banner'],
        mutationFn: async (banner: File) => {
            return api.account.profile_banner.change(banner)
        },
        onSuccess(data) {
            const viewerStore = useViewerStore()
            viewerStore.changeProfileBanner(data.data.data.banners)
        },
    })
}
