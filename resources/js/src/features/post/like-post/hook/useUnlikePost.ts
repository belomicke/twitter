import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useUnlikePost = () => {
    return useMutation({
        mutationKey: ['unlike-post'],
        mutationFn: async (id: number) => {
            const res = await api.posts.unlike(id)

            return res.data
        }
    })
}
