import { useMutation } from '@tanstack/vue-query'
import { useViewerStore } from '@/entities/Viewer/store'
import { api } from '@/shared/api/methods'

export const useChangeProfilePicture = () => {
    return useMutation({
        mutationKey: ['change-profile-picture'],
        mutationFn: async (picture: File) => {
            return api.account.profile_picture.change(picture)
        },
        onSuccess(data) {
            const viewerStore = useViewerStore()
            viewerStore.changeProfilePicture(data.data.data.pictures)
        }
    })
}
