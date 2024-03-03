import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { usePostStore } from '@/entities/Post/store'
import { useViewerStore } from '@/entities/Viewer/store'
import { useFeedStore } from '@/entities/Feed/store'

export const useLikePost = () => {
    return useMutation({
        mutationKey: ['like-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.like(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (data.success) {
                const postStore = usePostStore()

                postStore.likePost(variables)

                const viewerStore = useViewerStore()
                const viewer = viewerStore.viewer

                viewerStore.incrementFavouritesCount()

                const feedStore = useFeedStore()
                feedStore.addItemToStartOfFeed(`user:${viewer?.username}:liked_posts`, variables)
            }
        },
    })
}
