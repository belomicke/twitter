import { makeRequest } from '@/shared/api/makeRequest'
import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'

const getUserByUsername = async (username: string) => {
    return await makeRequest.get(`/api/users/${username}`)
}

const follow = async (username: string): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/users/${username}/follow`)
}

const unfollow = async (username: string): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/users/${username}/unfollow`)
}

export const users = {
    getUserByUsername,
    follow,
    unfollow,
}
