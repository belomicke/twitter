import { ApiResponse } from '@/shared/api/types/response'
import { IPost } from '@/shared/api/types/models/Post'
import IUser from '@/shared/api/types/models/User'
import { Media } from '@/shared/api/types/models/Media'

export interface PostItem {
    post: IPost
    user: IUser
}

export interface IPostExtensions {
    retweeted_post: PostApiItem | null
    media: Media[] | null
}

export interface PostApiItem extends PostItem {
    extensions: IPostExtensions
}

export type PostApiResponse = ApiResponse<PostApiItem>
