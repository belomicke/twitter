import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { usePostStore } from '@/entities/Post/store'
import { useViewerStore } from '@/entities/Viewer/store'

export const useUnlikePost = () => {
    return useMutation({
        mutationKey: ['unlike-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.unlike(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (data.success) {
                const postStore = usePostStore()

                postStore.unlikePost(variables)

                const viewerStore = useViewerStore()

                viewerStore.incrementFavouritesCount()
            }
        },
    })
}
