import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { api } from '@/shared/api/methods'
import { IFeed } from '@/shared/api/types/models/Feed'
import { PostFeedResponse } from '@/shared/api/types/response/feed/PostFeedResponse'
import { postApiItemHandle } from '@/entities/Post/helpers/postApiItemHandle'

export const useFeedStore = defineStore('feeds', () => {
    // store
    const feeds = ref<IFeed<number>[]>([])

    // getters
    const getFeedById = computed(() => {
        return (id: string) => feeds.value.find(feed => feed.id === id)
    })

    // actions
    function createFeed(id: string) {
        if (!feeds.value.find(item => item.id === id)) {
            feeds.value.push({
                id,
                data: {
                    items: [],
                    total: 0
                }
            })
        }
    }

    function addFeed(feed: IFeed<number>) {
        if (!feeds.value.find(item => item.id === feed.id)) {
            feeds.value.push(feed)
        }
    }

    function addItemToFeed(id: string, item: number) {
        const feed = feeds.value.find(item => item.id === id)

        if (feed && !feed.data.items.find(fi => fi === item)) {
            feed.data.items.push(item)
        }
    }

    function removeItemFromFeed(id: string, item: number) {
        const feed = feeds.value.find(item => item.id === id)

        if (!feed) return

        feed.data.items = feed.data.items.filter(i => i !== item)
        feed.data.total -= 1
    }

    function addItemToStartOfFeed(id: string, item: number) {
        const feed = feeds.value.find(item => item.id === id)

        if (feed && !feed.data.items.find(fi => fi === item)) {
            feed.data.items.unshift(item)
            feed.data.total += 1
        }
    }

    function addItemsToFeed(id: string, items: number[]) {
        items.forEach((item) => addItemToFeed(id, item))
    }

    function addItemsOrCreateFeed(id: string, items: number[], total: number) {
        const feed = feeds.value.find(item => item.id === id)

        if (feed) {
            addItemsToFeed(id, items)
            feed.data.total = total
        } else {
            const feedData = {
                id,
                data: {
                    total,
                    items
                }
            }

            addFeed(feedData)
        }
    }

    async function fetchUserPostsFeed(username: string) {
        const id = `user:${username}:posts`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0

        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && offset >= feed.data.total) return

        const res = await api.feed.user.getPosts(username, lastPostId)
        postFeedResponseHandler(id, res)
    }

    async function fetchPostCommentsFeed(postId: number) {
        const id = `post:${postId}:comments`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0

        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && offset >= feed.data.total) return

        const res = await api.feed.post.comments(postId, lastPostId)
        const data = res.data

        if (data.success) {
            const items = data.data.items

            items.forEach(item => {
                postApiItemHandle(item)
            })

            const postIds = items.map(item => item.post.id)
            const postThreadFeed = feeds.value.find(item => item.id === `post:${postId}:thread_history`)

            if (postThreadFeed) {
                const commentThreadItems = [postId, ...postThreadFeed.data.items]
                const commentThreadTotal = postThreadFeed.data.total + 1

                postIds.forEach(item => {
                    addItemsOrCreateFeed(
                        `post:${item}:thread_history`,
                        commentThreadItems,
                        commentThreadTotal
                    )
                })
            }

            addItemsOrCreateFeed(
                id,
                postIds,
                data.data.total
            )
        }
    }

    async function fetchPostThreadHistoryFeed(postId: number) {
        const id = `post:${postId}:thread_history`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0
        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && offset >= feed.data.total) return

        const res = await api.feed.post.thread_history(postId, lastPostId)
        const data = res.data

        if (data.success) {
            const items = data.data.items

            items.forEach(item => {
                postApiItemHandle(item)
            })

            const postIds = items.map(item => item.post.id)

            addItemsOrCreateFeed(
                `post:${postId}:thread_history`,
                postIds,
                data.data.total
            )

            for (let i = 0; i < postIds.length; i++) {
                let total = data.data.total - offset - i - 1

                addItemsOrCreateFeed(
                    `post:${postIds[i]}:thread_history`,
                    postIds.slice(i + 1, postIds.length),
                    total
                )

                const totalComments = data.data.items.find(item => item.post.id === postIds[i])?.post.reply_count

                if (totalComments) {
                    addItemsOrCreateFeed(
                        `post:${postIds[i]}:comments`,
                        [i - 1 < 0 ? postId : postIds[i - 1]],
                        totalComments
                    )
                }
            }
        }
    }

    async function fetchPostThreadFeed(postId: number) {
        const id = `post:${postId}:thread`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0
        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && offset >= feed.data.total) return

        const res = await api.feed.post.thread(postId, lastPostId)
        postFeedResponseHandler(id, res)
    }

    async function fetchUserLikedPostsFeed(username: string) {
        const id = `user:${username}:favorited_posts`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0

        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && offset >= feed.data.total) return

        const res = await api.feed.user.getLikedPosts(username, lastPostId)
        postFeedResponseHandler(id, res)
    }

    async function fetchTimelineFeed() {
        const id = `timeline`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0

        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && offset > feed.data.total) return

        const res = await api.feed.getTimeline(lastPostId)
        postFeedResponseHandler(id, res)
    }

    async function fetchPostsByQuery(query: string) {
        const id = `search:${query}`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0

        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && offset >= feed.data.total) return

        const res = await api.feed.query.posts(query, lastPostId)
        postFeedResponseHandler(id, res)
    }

    function postFeedResponseHandler(id: string, res: PostFeedResponse) {
        const data = res.data

        if (data.success) {
            const items = data.data.items

            items.forEach(item => {
                postApiItemHandle(item)
            })

            addItemsOrCreateFeed(
                id,
                items.map(item => item.post.id),
                data.data.total
            )
        }
    }

    return {
        getFeedById,
        addItemToStartOfFeed,
        removeItemFromFeed,
        fetchUserPostsFeed,
        fetchPostCommentsFeed,
        fetchPostThreadHistoryFeed,
        fetchTimelineFeed,
        fetchUserLikedPostsFeed,
        fetchPostsByQuery,
        fetchPostThreadFeed,
        createFeed
    }
})
