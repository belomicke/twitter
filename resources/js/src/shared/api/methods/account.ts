import axios from 'axios'
import { EntityExistsResponse } from '@/shared/api/types/response/global/EntityExistsResponse'

const checkEmail = async (email: string): Promise<EntityExistsResponse> => {
    return await axios.get(`/api/account/email_exists`, { params: { email } })
}

const checkUsername = async (username: string): Promise<EntityExistsResponse> => {
    return await axios.get(`/api/account/username_exists`, { params: { username } })
}

export const account = {
    checkEmail,
    checkUsername,
}
