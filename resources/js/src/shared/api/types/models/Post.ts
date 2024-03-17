export interface IPost {
    id: number
    text: string
    user_id: number
    retweeted_post_id: number | null
    liked: boolean
    retweeted: boolean
    likes_count: number
    retweets_count: number
    updated_at: string
    created_at: string
}
