import { makeRequest } from '@/shared/api/makeRequest'
import { PostResponse } from '@/shared/api/types/response/post/PostResponse'

export const create = async (data: CreatePostDTO) => {
    return await makeRequest.post(`/api/posts/create`, data)
}

export const getPostById = async (id: number): Promise<PostResponse> => {
    return await makeRequest.get(`/api/posts/${id}`)
}

export const posts = {
    create,
    getPostById,
}
