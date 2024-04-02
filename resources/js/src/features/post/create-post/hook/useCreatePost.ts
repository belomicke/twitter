import { useMutation } from '@tanstack/vue-query'
import { CreatePostDTO } from '../types/CreatePostDTO'
import { usePostStore } from '@/entities/Post/store'
import { useFeedStore } from '@/entities/Feed/store'
import { useViewerStore } from '@/entities/Viewer/store'
import { useAppNotificationStore } from '@/entities/App/store/AppNotificationStore'
import { api } from '@/shared/api/methods'

export const useCreatePost = () => {
    return useMutation({
        mutationKey: ['create-post'],
        mutationFn: async (data: CreatePostDTO) => {
            return await api.posts.create(data)
        },
        onSuccess(data) {
            if (!data.data.success && data.data.message) {
                const appNotificationsStore = useAppNotificationStore()
                appNotificationsStore.addNotification(data.data.message, 'danger')
                return
            }

            const post = data.data.data.post
            console.log(post.in_reply_to_post_id)

            const postStore = usePostStore()
            postStore.addPost(post)

            const viewerStore = useViewerStore()
            const viewer = viewerStore.viewer

            if (!viewer) return

            viewerStore.incrementPostsCount()

            const feedStore = useFeedStore()

            if (post.in_reply_to_post_id) {
                feedStore.createFeed(`post:${post.in_reply_to_post_id}:comments`)
                feedStore.addItemToStartOfFeed(`post:${post.in_reply_to_post_id}:comments`, post.id)
                postStore.incrementCommentsCount(post.in_reply_to_post_id)
            } else {
                feedStore.addItemToStartOfFeed(`user:${viewer.username}:posts`, post.id)
                feedStore.addItemToStartOfFeed(`timeline`, post.id)
            }
        }
    })
}
