import { useMutation } from '@tanstack/vue-query'
import { usePostStore } from '@/entities/Post/store'
import { useViewerStore } from '@/entities/Viewer/store'
import { useFeedStore } from '@/entities/Feed/store'
import { api } from '@/shared/api/methods'

export const useRetweetPost = () => {
    return useMutation({
        mutationKey: ['retweet-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.retweet.add(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (data.success) {
                const postStore = usePostStore()

                const post = data.data.post

                postStore.retweetPost(variables)
                postStore.addPost(post)

                const viewerStore = useViewerStore()
                const viewer = viewerStore.viewer

                viewerStore.incrementPostsCount()

                const feedStore = useFeedStore()
                feedStore.addItemToStartOfFeed(`user:${viewer?.username}:posts`, post.id)
                feedStore.addItemToStartOfFeed(`timeline`, post.id)
            }
        }
    })
}
