import { makeRequest } from '@/shared/api/makeRequest'

export const getUserByUsername = async (username: string) => {
    return await makeRequest.get(`/api/users/${username}`)
}

export const users = {
    getUserByUsername
}
