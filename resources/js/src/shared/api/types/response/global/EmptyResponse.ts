import { AxiosResponse } from 'axios'

export type EmptyResponse = AxiosResponse<{
    success: boolean
}>
