export interface CreatePostDTO {
    text: string
    retweeted_post_id: number | null
    in_reply_to_post_id: number | null
}
