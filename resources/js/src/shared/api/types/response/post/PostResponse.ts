import { ApiResponse } from '@/shared/api/types/response'
import { IPost } from '@/shared/api/types/models/Post'
import IUser from '@/shared/api/types/models/User'

export interface PostItem {
    post: IPost
    user: IUser
}

export interface IPostExtensions {
    retweet: PostItem | null
}

export type PostApiItem = {
    post: IPost
    user: IUser
    extensions: IPostExtensions
}

export type PostResponse = ApiResponse<PostApiItem>
