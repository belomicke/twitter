import { ApiResponse } from '@/shared/api/types/response'
import { IPost } from '@/shared/api/types/models/Post'
import IUser from '@/shared/api/types/models/User'

export interface PostFeedResponseItem {
    post: IPost
    user: IUser
}

export type PostFeedResponse = ApiResponse<{
    items: PostFeedResponseItem[]
    hasNextPage: boolean
    total: number
}>
