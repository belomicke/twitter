import { useMutation } from '@tanstack/vue-query'
import { useViewerStore } from '@/entities/Viewer/store'
import { useFeedStore } from '@/entities/Feed/store'
import { api } from '@/shared/api/methods'

export const useLikePost = () => {
    return useMutation({
        mutationKey: ['like-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.like(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (data.success) {
                if (!data.success) return

                const viewerStore = useViewerStore()
                const viewer = viewerStore.viewer

                const feedStore = useFeedStore()
                feedStore.addItemToStartOfFeed(`user:${viewer?.username}:liked_posts`, variables)
            }
        }
    })
}
