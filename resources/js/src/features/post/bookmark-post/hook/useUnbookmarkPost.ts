import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useUnbookmarkPost = () => {
    return useMutation({
        mutationKey: ['unbookmark-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.unbookmark(id)

            return res.data
        }
    })
}
