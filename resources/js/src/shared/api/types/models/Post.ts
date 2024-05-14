export interface IPost {
    id: number
    text: string
    user_id: number

    like_count: number
    liked: boolean

    in_reply_to_post_id: number | null
    in_reply_to_user_id: number | null
    in_reply_to_username: string | null
    reply_count: number

    updated_at: string
    created_at: string

    is_pinned: boolean
    is_favorite: boolean

    bookmarked: boolean

    is_quote: boolean
    quote_count: number

    retweeted_post_id: number | null
    retweet_count: number
    retweeted: boolean

    media_count: number

    is_deleted: boolean
}
