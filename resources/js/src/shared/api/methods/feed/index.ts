import { user } from './user'
import { makeRequest } from '@/shared/api/makeRequest'
import { RequestFeedConfig } from '@/shared/api/types/DTO/feed/RequestFeedConfig'
import { PostFeedResponse } from '@/shared/api/types/response/feed/PostFeedResponse'

const getTimeline = async (config: RequestFeedConfig): Promise<PostFeedResponse> => {
    return await makeRequest.get('/api/feed/timeline', { params: config })
}

export const feed = {
    user,
    getTimeline,
}
