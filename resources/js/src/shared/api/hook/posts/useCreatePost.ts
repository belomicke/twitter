import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'

export const useCreatePost = () => {
	return useMutation({
		mutationKey: ['create-post'],
		mutationFn: async (data: CreatePostDTO) => {
			return await api.posts.create(data)
		},
	})
}
