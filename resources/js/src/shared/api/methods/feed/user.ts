import { UserPostsFeedResponse } from '@/shared/api/types/response/feed/UserPostsFeedResponse'

import { makeRequest } from '../../makeRequest'
import { RequestFeedConfig } from '../../types/DTO/feed/RequestFeedConfig'

const getPosts = async (username: string, config: RequestFeedConfig): Promise<UserPostsFeedResponse> => {
    return await makeRequest.get(`/api/feed/user/${username}/posts`, { params: config })
}

export const user = {
    getPosts,
}
