import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { usePostStore } from '@/entities/Post/store'

export const usePinPost = () => {
    return useMutation({
        mutationKey: ['pin-post'],
        mutationFn: (id: number) => {
            return api.posts.pin.set(id)
        },
        onSuccess: (data, variables) => {
            const postStore = usePostStore()

            postStore.pinPost(variables)
        }
    })
}
