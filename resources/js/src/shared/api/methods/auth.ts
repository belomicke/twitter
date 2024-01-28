import axios from 'axios'
import CreateAccountDTO from '@/shared/api/types/DTO/auth/CreateAccountDTO'
import CreateAccessTokenDTO from '@/shared/api/types/DTO/auth/CreateAccessTokenDTO'
import { CreateAccessTokenResponse } from '@/shared/api/types/response/auth/CreateAccessTokenResponse'
import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'

const createAccount = async (data: CreateAccountDTO): Promise<EmptyResponse> => {
    return await axios.post('/api/auth/create_account', data)
}

const sendVerificationCode = async (email: string): Promise<EmptyResponse> => {
    return await axios.post('/api/auth/send_verification_code', { email })
}

const createAccessToken = async (data: CreateAccessTokenDTO): Promise<CreateAccessTokenResponse> => {
    return await axios.post('/api/auth/create_access_token', data)
}

export const auth = {
    createAccount,
    sendVerificationCode,
    createAccessToken
}
