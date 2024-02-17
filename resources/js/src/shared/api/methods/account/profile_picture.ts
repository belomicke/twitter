import { ApiResponse } from '@/shared/api/types/response'
import { ProfilePictures } from '@/shared/api/types/models/User'
import { makeRequest } from '@/shared/api/makeRequest'

const change = async (picture: File): Promise<ApiResponse<{ pictures: ProfilePictures }>> => {
    const data = new FormData()

    data.append('profile_picture', picture)

    return await makeRequest.post('/api/account/profile_picture', data)
}

const remove = async (): Promise<ApiResponse<{ pictures: ProfilePictures }>> => {
    return await makeRequest.delete('/api/account/profile_picture')
}

export const profile_picture = {
    change,
    remove,
}
