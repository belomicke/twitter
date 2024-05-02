import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'
import { makeRequest } from '@/shared/api/makeRequest'

const like = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/posts/${id}/like`)
}

const unlike = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/posts/${id}/unlike`)
}

export {
    like,
    unlike
}
