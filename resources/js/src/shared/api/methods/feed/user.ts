import { UserPostsFeedResponse } from '@/shared/api/types/response/feed/UserPostsFeedResponse'

import { makeRequest } from '../../makeRequest'
import { PostFeedResponse } from '@/shared/api/types/response/feed/PostFeedResponse'

const getPosts = async (username: string, lastPostId: number): Promise<UserPostsFeedResponse> => {
    return await makeRequest.get(`/api/feed/user/${username}/posts`, { params: { last_post_id: lastPostId } })
}

const getLikedPosts = async (username: string, lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get(`/api/feed/user/${username}/liked_posts`, { params: { last_post_id: lastPostId } })
}

export const user = {
    getPosts,
    getLikedPosts,
}
