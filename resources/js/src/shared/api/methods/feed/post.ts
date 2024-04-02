import { makeRequest } from '../../makeRequest'
import { PostFeedResponse } from '@/shared/api/types/response/feed/PostFeedResponse'

const comments = async (id: number, lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get(`/api/feed/post/${id}/comments`, { params: { last_post_id: lastPostId } })
}

const thread = async (id: number, lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get(`/api/feed/post/${id}/thread`, { params: { last_post_id: lastPostId } })
}

const thread_history = async (id: number, lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get(`/api/feed/post/${id}/thread_history`, { params: { last_post_id: lastPostId } })
}

export const post = {
    comments,
    thread,
    thread_history
}
