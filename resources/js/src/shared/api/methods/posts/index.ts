import FormData from 'form-data'
import { pin } from './pin'
import { like, unlike } from './like'
import { retweet } from './retweet'
import { makeRequest } from '@/shared/api/makeRequest'
import { PostApiResponse } from '@/shared/api/types/response/post/PostResponse'
import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'

const getById = async (id: number): Promise<PostApiResponse> => {
    return await makeRequest.get(`/api/posts/${id}`)
}

const create = async (text: string, media: File[]): Promise<PostApiResponse> => {
    const formData = new FormData()

    formData.append('text', text)

    media.forEach(mediaFile => formData.append('media[]', mediaFile))

    return await makeRequest.post(`/api/posts/create`, formData)
}

const quote = async (id: number, text: string, media: File[]): Promise<PostApiResponse> => {
    const formData = new FormData()

    formData.append('text', text)

    media.forEach(mediaFile => formData.append('media[]', mediaFile))

    return await makeRequest.post(`/api/posts/${id}/quote`, formData)
}

const reply = async (id: number, text: string, media: File[]): Promise<PostApiResponse> => {
    const formData = new FormData()

    formData.append('text', text)

    media.forEach(mediaFile => formData.append('media[]', mediaFile))

    return await makeRequest.post(`/api/posts/${id}/reply`, formData)
}

const deletePost = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.delete(`/api/posts/${id}`)
}

const bookmark = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/posts/${id}/bookmark`)
}

const unbookmark = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.delete(`/api/posts/${id}/bookmark`)
}

const addToFavoriteList = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/posts/${id}/favorite`)
}

const removeFromFavoriteList = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.delete(`/api/posts/${id}/favorite`)
}

export const posts = {
    getById,
    create,
    quote,
    reply,
    deletePost,

    like,
    unlike,

    bookmark,
    unbookmark,

    addToFavoriteList,
    removeFromFavoriteList,

    retweet,
    pin
}
