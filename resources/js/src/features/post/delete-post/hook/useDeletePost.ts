import { useMutation } from '@tanstack/vue-query'
import { usePostStore } from '@/entities/Post/store'
import { useViewerStore } from "@/entities/Viewer/store"
import { api } from '@/shared/api/methods'

export const useDeletePost = () => {
    return useMutation({
        mutationKey: ['delete-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.deletePost(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (!data.success) return

            const viewerStore = useViewerStore()
            const viewer = viewerStore.viewer

            const postStore = usePostStore()
            const post = postStore.getPostById(variables)

            if (!post) return
            if (!viewer) return

            viewerStore.decrementPostsCount()

            if (post.liked) {
                viewerStore.decrementLikedPostsCount()
            }

            if (post.is_favorite) {
                viewerStore.decrementFavoritePostsCount()
            }

            if (post.retweeted) {
                viewerStore.decrementPostsCount()
            }

            if (post.media_count) {
                viewer.media_count -= post.media_count
                viewer.media_posts_count--
            }

            postStore.deletePost(variables)
        }
    })
}
