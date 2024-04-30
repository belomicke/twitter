import { useUserStore } from '@/entities/User/store'
import { usePostStore } from '@/entities/Post/store'
import { PostApiItem } from '@/shared/api/types/response/post/PostResponse'
import { useMediaStore } from '@/entities/Media/store'

export const postApiItemHandle = (item: PostApiItem) => {
    const userStore = useUserStore()
    const postStore = usePostStore()
    const mediaStore = useMediaStore()

    postStore.addPost(item.post)
    userStore.addUser(item.user)

    if (item.extensions.media !== null) {
        item.extensions.media.forEach(media => mediaStore.addMedia(media))
    }

    if (item.extensions.retweeted_post !== null) {
        postApiItemHandle(item.extensions.retweeted_post)
    }
}
