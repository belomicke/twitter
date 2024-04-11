import { favorite } from './favorite'
import { retweet } from './retweet'
import { makeRequest } from '@/shared/api/makeRequest'
import { PostApiResponse } from '@/shared/api/types/response/post/PostResponse'

const getById = async (id: number): Promise<PostApiResponse> => {
    return await makeRequest.get(`/api/posts/${id}`)
}

const create = async (text: string): Promise<PostApiResponse> => {
    return await makeRequest.post(`/api/posts/create`, { text })
}

const quote = async (id: number, text: string): Promise<PostApiResponse> => {
    return await makeRequest.post(`/api/posts/${id}/quote`, { text })
}

const reply = async (id: number, text: string): Promise<PostApiResponse> => {
    return await makeRequest.post(`/api/posts/${id}/reply`, { text })
}

export const posts = {
    getById,
    create,
    quote,
    reply,

    retweet,
    favorite

}
