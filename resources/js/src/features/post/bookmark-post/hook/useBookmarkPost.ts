import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useBookmarkPost = () => {
    return useMutation({
        mutationKey: ['bookmark-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.bookmark(id)

            return res.data
        }
    })
}
