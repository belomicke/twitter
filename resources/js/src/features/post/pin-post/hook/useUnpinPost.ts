import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { usePostStore } from '@/entities/Post/store'

export const useUnpinPost = () => {
    return useMutation({
        mutationKey: ['unpin-post'],
        mutationFn: (id: number) => {
            return api.posts.pin.remove(id)
        },
        onSuccess: (data, variables) => {
            const postStore = usePostStore()

            postStore.unpinPost(variables)
        }
    })
}
