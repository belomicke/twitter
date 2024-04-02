import { useUserStore } from '@/entities/User/store'
import { usePostStore } from '@/entities/Post/store'
import { PostApiItem } from '@/shared/api/types/response/post/PostResponse'

export const postApiItemHandle = (item: PostApiItem) => {
    const userStore = useUserStore()
    const postStore = usePostStore()

    postStore.addPost(item.post)
    userStore.addUser(item.user)

    if (item.extensions.retweeted_post !== null) {
        postStore.addPost(item.extensions.retweeted_post.post)
        userStore.addUser(item.extensions.retweeted_post.user)
    }
}
