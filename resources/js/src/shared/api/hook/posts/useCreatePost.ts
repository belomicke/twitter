import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { usePostStore } from '@/entities/Post/store'
import { useFeedStore } from '@/entities/Feed/store'
import { useViewerStore } from '@/entities/Viewer/store'

export const useCreatePost = () => {
    return useMutation({
        mutationKey: ['create-post'],
        mutationFn: async (data: CreatePostDTO) => {
            return await api.posts.create(data)
        },
        onSuccess(data) {
            if (!data.data.success) return

            const post = data.data.data.post

            const postStore = usePostStore()
            postStore.addPost(post)

            const viewerStore = useViewerStore()
            const viewer = viewerStore.viewer

            if (!viewer) return

            viewerStore.incrementPostsCount()

            const feedStore = useFeedStore()
            feedStore.addItemToStartOfFeed(`user:${viewer.username}:posts`, post.id)
            feedStore.addItemToStartOfFeed(`timeline`, post.id)
        },
    })
}
