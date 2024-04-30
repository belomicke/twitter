import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'
import { makeRequest } from '@/shared/api/makeRequest'

const set = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/posts/${id}/pin`)
}

const remove = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.delete(`/api/posts/${id}/pin`)
}

export const pin = {
    set,
    remove
}
