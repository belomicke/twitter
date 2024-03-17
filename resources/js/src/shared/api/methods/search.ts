import { makeRequest } from '@/shared/api/makeRequest'
import { UserFeedResponse } from '@/shared/api/types/response/feed/UserFeedResponse'

const getUsers = async (query: string): Promise<UserFeedResponse> => {
    return await makeRequest.get(`/api/search/users`, { params: { query } })
}

export const search = {
    getUsers
}
