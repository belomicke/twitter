import { ApiResponse } from '@/shared/api/types/response'
import { ProfileBanners } from '@/shared/api/types/models/User'
import { makeRequest } from '@/shared/api/makeRequest'

const change = async (banner: File): Promise<ApiResponse<{ banners: ProfileBanners }>> => {
    const data = new FormData()

    data.append('profile_banner', banner)

    return await makeRequest.post('/api/account/profile_banner', data)
}

const remove = async (): Promise<ApiResponse<{ banners: ProfileBanners }>> => {
    return await makeRequest.delete('/api/account/profile_banner')
}

export const profile_banner = {
    change,
    remove,
}
