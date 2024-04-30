export interface Media {
    id: number
    post_id: number
    width: number
    height: number
    path: string
    filename: string
    'mime_type': 'image/jpeg' | 'image/png'
}
