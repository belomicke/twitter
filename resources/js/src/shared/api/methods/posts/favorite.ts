import { EmptyResponse } from '@/shared/api/types/response/global/EmptyResponse'
import { makeRequest } from '@/shared/api/makeRequest'

const add = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.post(`/api/posts/${id}/favorite`)
}

const remove = async (id: number): Promise<EmptyResponse> => {
    return await makeRequest.delete(`/api/posts/${id}/favorite`)
}

export const favorite = {
    add,
    remove
}
