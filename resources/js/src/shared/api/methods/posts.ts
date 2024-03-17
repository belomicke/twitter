import { makeRequest } from '@/shared/api/makeRequest'
import { PostResponse } from '@/shared/api/types/response/post/PostResponse'
import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'

const create = async (data: CreatePostDTO) => {
    return await makeRequest.post(`/api/posts/create`, data)
}

const getPostById = async (id: number): Promise<PostResponse> => {
    return await makeRequest.get(`/api/posts/${id}`)
}

const like = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/posts/${id}/like`)
}

const unlike = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/posts/${id}/unlike`)
}

const retweet = async (id: number): Promise<PostResponse> => {
    return await makeRequest.post(`/api/posts/${id}/retweet`)
}

const undoRetweet = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.delete(`/api/posts/${id}/retweet`)
}

export const posts = {
    create,
    getPostById,
    like,
    unlike,

    retweet,
    undoRetweet,
}
