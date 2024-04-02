import { ApiResponse } from '@/shared/api/types/response'
import { IPost } from '@/shared/api/types/models/Post'
import IUser from '@/shared/api/types/models/User'

export interface PostItem {
    post: IPost
    user: IUser
}

export interface IPostExtensions {
    retweeted_post: PostItem | null
}

export type PostApiItem = {
    post: IPost
    user: IUser
    extensions: IPostExtensions
}

export type PostApiResponse = ApiResponse<PostApiItem>
