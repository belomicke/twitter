import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { useViewerStore } from '@/entities/Viewer/store'

export const useDeleteProfilePicture = () => {
    return useMutation({
        mutationKey: ['delete-profile-picture'],
        mutationFn: async () => {
            return await api.account.profile_picture.remove()
        },
        onSuccess(data) {
            const viewerStore = useViewerStore()
            viewerStore.changeProfilePicture(data.data.data.pictures)
        },
    })
}
