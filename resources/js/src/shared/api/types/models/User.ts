export interface ProfilePictures {
    large: string
    default: string
    small: string
}

export interface ProfileBanners {
    large: string
    default: string
}

export default interface IUser {
    id: number
    name: string
    username: string
    profile_picture: ProfilePictures
    profile_banner: ProfileBanners
    birth: string
    bio: string
    location: string
    link: string
    following: boolean
    posts_count: number
    media_posts_count: number
    favorite_posts_count: number
    media_count: number
    liked_posts_count: number
    follows_count: number
    followers_count: number
    created_at: string
}
