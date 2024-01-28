import { AxiosResponse } from 'axios'
import { ApiResponse } from '@/shared/api/types/response'

export type CreateAccessTokenResponse = AxiosResponse<ApiResponse<{ token: string }>>
