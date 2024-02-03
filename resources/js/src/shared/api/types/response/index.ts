import { AxiosResponse } from 'axios'

export type ApiResponse<T> = AxiosResponse<{
    success: boolean
    data: T
}>
