import { useMutation } from "@tanstack/vue-query"
import { usePostStore } from "@/entities/Post/store"
import { useFeedStore } from "@/entities/Feed/store"
import { useViewerStore } from "@/entities/Viewer/store"
import { api } from "@/shared/api/methods"

export const useAddPostToFavoriteList = () => {
    return useMutation({
        mutationKey: ['add-post-to-favorite-list'],
        mutationFn: async (id: number) => {
            const res = await api.posts.addToFavoriteList(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (!data.success) return

            const postStore = usePostStore()
            postStore.addPostToFavoriteList(variables)

            const viewerStore = useViewerStore()
            const viewer = viewerStore.viewer

            if (!viewer) return

            viewerStore.incrementFavoritePostsCount()

            const feedStore = useFeedStore()
            feedStore.addItemToStartOfFeed(`user:${viewer.username}:favorite_posts`, variables)
        },
    })
}
