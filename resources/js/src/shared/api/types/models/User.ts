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
    posts_count: number
    follows_count: number
    followers_count: number
    updated_at: string
    created_at: string
}
