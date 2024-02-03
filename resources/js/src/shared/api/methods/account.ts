import axios from 'axios'
import { EntityExistsResponse } from '@/shared/api/types/response/global/EntityExistsResponse'
import { makeRequest } from '@/shared/api/makeRequest'
import EditViewerPublicDataDTO from '@/shared/api/types/DTO/account/EditViewerPublicDataDTO'
import { UserResponse } from '@/shared/api/types/response/user/UserResponse'

const checkEmail = async (email: string): Promise<EntityExistsResponse> => {
    return await axios.get(`/api/account/email_exists`, { params: { email } })
}

const checkUsername = async (username: string): Promise<EntityExistsResponse> => {
    return await axios.get(`/api/account/username_exists`, { params: { username } })
}

const getViewer = async (): Promise<UserResponse> => {
    return await makeRequest.get(`/api/account/viewer`)
}

const editPublicData = async (data: EditViewerPublicDataDTO): Promise<UserResponse> => {
    return await makeRequest.patch('/api/account/edit_public_data', data)
}

export const account = {
    checkEmail,
    checkUsername,
    getViewer,
    editPublicData,
}
