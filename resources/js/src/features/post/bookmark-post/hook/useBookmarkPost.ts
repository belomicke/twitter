import { useMutation } from '@tanstack/vue-query'
import { useFeedStore } from "@/entities/Feed/store"
import { api } from '@/shared/api/methods'

export const useBookmarkPost = () => {
    return useMutation({
        mutationKey: ['bookmark-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.bookmark(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (!data.success) return

            const feedStore = useFeedStore()
            feedStore.addItemToStartOfFeed('bookmarked-posts', variables)
        },
    })
}
