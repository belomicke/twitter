import { makeRequest } from '@/shared/api/makeRequest'
import {
    PostFeedResponse,
} from '@/shared/api/types/response/feed/PostFeedResponse'

import { RequestFeedConfig } from '../../types/DTO/feed/RequestFeedConfig'
import { user } from './user'

const getFollowingsPosts = async (config: RequestFeedConfig): Promise<PostFeedResponse> => {
    return await makeRequest.get('/api/feed/followings_posts', { params: config })
}

export const feed = {
    user,
    getFollowingsPosts,
}
