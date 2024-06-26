import { makeRequest } from '../../makeRequest'
import { PostFeedResponse } from '@/shared/api/types/response/feed/PostFeedResponse'

const replies = async (id: number, lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get(`/api/feed/post/${id}/replies`, { params: { last_post_id: lastPostId } })
}

const thread = async (id: number, lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get(`/api/feed/post/${id}/thread`, { params: { last_post_id: lastPostId } })
}

const thread_history = async (id: number, lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get(`/api/feed/post/${id}/thread_history`, { params: { last_post_id: lastPostId } })
}

const bookmarked = async (lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get('/api/feed/post/bookmarked', { params: { last_post_id: lastPostId } })
}

export const post = {
    replies,
    thread,
    bookmarked,
    thread_history
}
