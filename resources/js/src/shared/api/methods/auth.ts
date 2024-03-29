import CreateAccountDTO from '@/features/auth/create-account/types/CreateAccountDTO'
import CreateAccessTokenDTO from '@/features/auth/log-in/types/CreateAccessTokenDTO'
import { CreateAccessTokenResponse } from '@/shared/api/types/response/auth/CreateAccessTokenResponse'
import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'
import { makeRequest } from '@/shared/api/makeRequest'

const createAccount = async (data: CreateAccountDTO): Promise<EmptyResponse> => {
    return await makeRequest.post('/api/auth/create_account', data)
}

const sendVerificationCode = async (email: string): Promise<EmptyResponse> => {
    return await makeRequest.post('/api/auth/send_verification_code', { email })
}

const createAccessToken = async (data: CreateAccessTokenDTO): Promise<CreateAccessTokenResponse> => {
    return await makeRequest.post('/api/auth/access_token', data)
}

export const deleteViewerAccessToken = async (): Promise<EmptyResponse> => {
    return await makeRequest.delete('/api/auth/access_token')
}

export const auth = {
    createAccount,
    sendVerificationCode,
    createAccessToken,
    deleteViewerAccessToken,
}
