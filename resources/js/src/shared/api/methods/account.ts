import axios from 'axios'
import { EntityExistsResponse } from '@/shared/api/types/response/global/EntityExistsResponse'
import { makeRequest } from '@/shared/api/makeRequest'

const checkEmail = async (email: string): Promise<EntityExistsResponse> => {
    return await axios.get(`/api/account/email_exists`, { params: { email } })
}

const checkUsername = async (username: string): Promise<EntityExistsResponse> => {
    return await axios.get(`/api/account/username_exists`, { params: { username } })
}

export const getViewer = async () => {
    return await makeRequest.get(`/api/account/viewer`)
}

export const account = {
    checkEmail,
    checkUsername,
    getViewer,
}
