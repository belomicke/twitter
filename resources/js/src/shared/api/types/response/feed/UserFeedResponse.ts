import { ApiResponse } from '@/shared/api/types/response'
import IUser from '@/shared/api/types/models/User'

export type UserFeedResponse = ApiResponse<{
    items: IUser[]
    total: number
}>
