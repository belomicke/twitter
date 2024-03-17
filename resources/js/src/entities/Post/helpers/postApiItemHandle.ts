import { useUserStore } from '@/entities/User/store'
import { usePostStore } from '@/entities/Post/store'
import { PostApiItem } from '@/shared/api/types/response/post/PostResponse'

export const postApiItemHandle = (item: PostApiItem) => {
    const userStore = useUserStore()
    const postStore = usePostStore()

    postStore.addPost(item.post)
    userStore.addUser(item.user)

    if (item.extensions.retweet !== null) {
        postStore.addPost(item.extensions.retweet.post)
        userStore.addUser(item.extensions.retweet.user)
    }
}
