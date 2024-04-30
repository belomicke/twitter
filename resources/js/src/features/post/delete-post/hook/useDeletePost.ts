import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { usePostStore } from '@/entities/Post/store'

export const useDeletePost = () => {
    return useMutation({
        mutationKey: ['delete-post'],
        mutationFn: async (id: number) => {
            return await api.posts.deletePost(id)
        },
        onSuccess(data, variables, context) {
            const postStore = usePostStore()
            postStore.deletePost(variables)
        }
    })
}
