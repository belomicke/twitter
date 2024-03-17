import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { usePostStore } from '@/entities/Post/store'
import { useViewerStore } from '@/entities/Viewer/store'
import { useFeedStore } from '@/entities/Feed/store'

export const useUndoRetweetPost = () => {
    return useMutation({
        mutationKey: ['undo-retweet-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.undoRetweet(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (data.success) {
                const postStore = usePostStore()

                postStore.undoRetweetPost(variables)

                const viewerStore = useViewerStore()
                const viewer = viewerStore.viewer

                viewerStore.decrementPostsCount()

                const retweet = postStore.getRetweetByPostId(variables)

                if (!retweet) return

                const feedStore = useFeedStore()
                feedStore.removeItemFromFeed(`user:${viewer?.username}:posts`, retweet.id)

                postStore.deletePostRetweet(variables)
            }
        }
    })
}
