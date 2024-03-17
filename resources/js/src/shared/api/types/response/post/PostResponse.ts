import { ApiResponse } from '@/shared/api/types/response'
import { IPost } from '@/shared/api/types/models/Post'
import IUser from '@/shared/api/types/models/User'
import { IPostExtensions } from '@/shared/api/types/response/feed/PostFeedResponse'

export type PostResponse = ApiResponse<{
    post: IPost
    user: IUser
    extensions: IPostExtensions
}>
