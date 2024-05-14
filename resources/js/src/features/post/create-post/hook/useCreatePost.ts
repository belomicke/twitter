import { useMutation } from '@tanstack/vue-query'
import { CreatePostDTO } from '../types/CreatePostDTO'
import { usePostStore } from '@/entities/Post/store'
import { useFeedStore } from '@/entities/Feed/store'
import { useViewerStore } from '@/entities/Viewer/store'
import { useAppNotificationStore } from '@/entities/App/store/AppNotificationStore'
import { useMediaStore } from '@/entities/Media/store'
import { api } from '@/shared/api/methods'

export const useCreatePost = () => {
    return useMutation({
        mutationKey: ['create-post'],
        mutationFn: async (data: CreatePostDTO) => {
            if (data.text.length === 0 && data.media.length === 0) return
            if (data.retweeted_post_id !== null) {
                return await api.posts.quote(data.retweeted_post_id, data.text, data.media)
            }

            if (data.in_reply_to_post_id !== null) {
                return await api.posts.reply(data.in_reply_to_post_id, data.text, data.media)
            }

            return await api.posts.create(data.text, data.media)
        },
        onSuccess(data) {
            if (!data) return

            if (!data.data.success && data.data.message) {
                const appNotificationsStore = useAppNotificationStore()
                appNotificationsStore.addNotification(data.data.message, 'danger')
                return
            }

            const post = data.data.data.post

            const postStore = usePostStore()
            postStore.addPost(post)

            const feedStore = useFeedStore()

            if (post.in_reply_to_post_id) {
                const inReplyToPost = postStore.getPostById(post.in_reply_to_post_id)

                if (inReplyToPost) {
                    postStore.incrementCommentsCount(post.in_reply_to_post_id)

                    if (inReplyToPost.reply_count === 0) {
                        feedStore.createFeed(`post:${post.in_reply_to_post_id}:replies`)
                    }

                    feedStore.addItemToStartOfFeed(`post:${post.in_reply_to_post_id}:replies`, post.id)
                }
            } else {
                feedStore.addItemToStartOfFeed('timeline', post.id)

                const viewerStore = useViewerStore()
                const viewer = viewerStore.viewer

                if (!viewer) return

                feedStore.addItemToStartOfFeed(`user:${viewer.username}:posts`, post.id)
                viewerStore.incrementPostsCount()
            }

            if (data.data.data.extensions.media !== null) {
                const mediaStore = useMediaStore()
                data.data.data.extensions.media.forEach(media => mediaStore.addMedia(media))
            }
        }
    })
}
