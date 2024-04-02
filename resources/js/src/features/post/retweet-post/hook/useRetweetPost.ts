import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { usePostStore } from '@/entities/Post/store'
import { useViewerStore } from '@/entities/Viewer/store'
import { useFeedStore } from '@/entities/Feed/store'
import { useUserStore } from '@/entities/User/store'

export const useRetweetPost = () => {
    return useMutation({
        mutationKey: ['retweet-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.retweet(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (data.success) {
                const postStore = usePostStore()
                const userStore = useUserStore()

                const post = data.data.post

                postStore.retweetPost(variables)

                postStore.addPost(post)

                const retweet = data.data.extensions.retweeted_post

                if (retweet) {
                    postStore.addPost(retweet.post)
                    userStore.addUser(retweet.user)
                }

                const viewerStore = useViewerStore()
                const viewer = viewerStore.viewer

                viewerStore.incrementPostsCount()

                const feedStore = useFeedStore()
                feedStore.addItemToStartOfFeed(`user:${viewer?.username}:posts`, post.id)
            }
        }
    })
}
