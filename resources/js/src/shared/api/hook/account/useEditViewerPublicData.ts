import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import EditViewerPublicDataDTO from '@/shared/api/types/DTO/account/EditViewerPublicDataDTO'
import { useViewerStore } from '@/entities/Viewer/store'

export const useEditViewerPublicData = () => {
    return useMutation({
        mutationKey: ['edit-viewer-public-data'],
        mutationFn: async (data: EditViewerPublicDataDTO) => {
            return await api.account.editPublicData(data)
        },
        onSuccess(data) {
            if (data.data.success) {
                const viewerStore = useViewerStore()

                viewerStore.editViewer(data.data.data.user)
            }
        },
    })
}
