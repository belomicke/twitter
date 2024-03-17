import { makeRequest } from '@/shared/api/makeRequest'

const posts = async (query: string, lastPostId: number) => {
    return await makeRequest.get(`/api/feed/query/posts`, { params: { query, last_post_id: lastPostId } })
}

export const query = {
    posts
}
