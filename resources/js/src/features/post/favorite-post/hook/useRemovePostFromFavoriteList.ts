import { useMutation } from "@tanstack/vue-query"
import { usePostStore } from "@/entities/Post/store"
import { api } from "@/shared/api/methods"

export const useRemovePostFromFavoriteList = () => {
    return useMutation({
        mutationKey: ['remove-post-from-favorite-list'],
        mutationFn: async (id: number) => {
            const res = await api.posts.removeFromFavoriteList(id)

            return res.data
        },
        onSuccess(data, variables) {
            if (!data.success) return

            const postStore = usePostStore()
            postStore.removePostFromFavoriteList(variables)
        },
    })
}
