import { user } from './user'
import { query } from './query'
import { makeRequest } from '@/shared/api/makeRequest'
import { PostFeedResponse } from '@/shared/api/types/response/feed/PostFeedResponse'

const getTimeline = async (lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get('/api/feed/timeline', { params: { last_post_id: lastPostId } })
}

export const feed = {
    user,
    query,
    getTimeline,
}
