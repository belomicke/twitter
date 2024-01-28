import { AxiosResponse } from 'axios'

export type EntityExistsResponse = AxiosResponse<{
    success: boolean
    data: {
        exists: boolean
    }
}>
