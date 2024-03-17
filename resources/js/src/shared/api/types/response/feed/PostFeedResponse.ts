import { ApiResponse } from '@/shared/api/types/response'
import { PostApiItem } from '@/shared/api/types/response/post/PostResponse'

export type PostFeedResponse = ApiResponse<{
    items: PostApiItem[]
    total: number
}>
