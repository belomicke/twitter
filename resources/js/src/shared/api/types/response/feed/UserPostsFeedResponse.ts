import { ApiResponse } from '@/shared/api/types/response'
import { IPost } from '@/shared/api/types/models/Post'

export type UserPostsFeedResponse = ApiResponse<{
    items: IPost[]
    hasNextPage: boolean
    total: number
}>
