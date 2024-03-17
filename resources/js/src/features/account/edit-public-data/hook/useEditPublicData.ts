import { useMutation } from '@tanstack/vue-query'
import EditPublicDataDTO from '../types/EditPublicDataDTO'
import { useViewerStore } from '@/entities/Viewer/store'
import { api } from '@/shared/api/methods'

export const useEditPublicData = () => {
    return useMutation({
        mutationKey: ['edit-viewer-public-data'],
        mutationFn: async (data: EditPublicDataDTO) => {
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
