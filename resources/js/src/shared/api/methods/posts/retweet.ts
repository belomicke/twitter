import { PostApiResponse } from '@/shared/api/types/response/post/PostResponse'
import { makeRequest } from '@/shared/api/makeRequest'
import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'

const add = async (id: number): Promise<PostApiResponse> => {
    return await makeRequest.post(`/api/posts/${id}/retweet`)
}

const remove = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.delete(`/api/posts/${id}/retweet`)
}

export const retweet = {
    add,
    remove
}
