import { ApiResponse } from '@/shared/api/types/response'
import { IPost } from '@/shared/api/types/models/Post'
import { IPostExtensions } from '@/shared/api/types/response/feed/PostFeedResponse'

export interface UserPostsFeedItem {
    post: IPost
    extensions: IPostExtensions
}

export type UserPostsFeedResponse = ApiResponse<{
    items: UserPostsFeedItem[]
    total: number
}>
