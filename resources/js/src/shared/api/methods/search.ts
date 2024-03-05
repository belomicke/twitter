import { makeRequest } from '@/shared/api/makeRequest'
import { UserFeedResponse } from '@/shared/api/types/response/feed/UserFeedResponse'
import { PostFeedResponse } from '@/shared/api/types/response/feed/PostFeedResponse'

const getUsers = async (query: string): Promise<UserFeedResponse> => {
    return await makeRequest.get(`/api/search/users`, { params: { query } })
}

const getPosts = async (query: string, lastPostId: number): Promise<PostFeedResponse> => {
    return await makeRequest.get(`/api/search/posts`, { params: { query, last_post_id: lastPostId } })
}

export const search = {
    getUsers,
    getPosts,
}
