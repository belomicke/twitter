import { computed, ref } from 'vue'

import { defineStore } from 'pinia'

import { usePostStore } from '@/entities/Post/store'
import { api } from '@/shared/api/methods'
import { IFeed } from '@/shared/api/types/models/Feed'
import { useUserStore } from '@/entities/User/store'
import { PostFeedResponse } from '@/shared/api/types/response/feed/PostFeedResponse'

export const useFeedStore = defineStore('feeds', () => {
    // store
    const feeds = ref<IFeed<number>[]>([])

    // getters
    const getFeedById = computed(() => {
        return (id: string) => feeds.value.find(feed => feed.id === id)
    })

    // actions
    function addFeed(feed: IFeed<number>) {
        if (!feeds.value.find(item => item.id === feed.id)) {
            feeds.value.push(feed)
        }
    }

    function addItemToFeed(id: string, item: number) {
        const feed = feeds.value.find(item => item.id === id)

        if (feed) {
            feed.data.items.push(item)
        }
    }

    function addItemToStartOfFeed(id: string, item: number) {
        const feed = feeds.value.find(item => item.id === id)

        if (feed) {
            feed.data.items.unshift(item)
            feed.data.total += 1
        }
    }

    function addItemsToFeed(id: string, items: number[]) {
        items.forEach((item) => addItemToFeed(id, item))
    }

    async function fetchUserPostsFeed(username: string) {
        const id = `user:${username}:posts`
        const feed = feeds.value.find(item => item.id === id)

        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && feed.data.items.length >= feed.data.total) return

        const res = await api.feed.user.getPosts(username, lastPostId)
        const data = res.data

        if (data.success) {
            const items = data.data.items

            const postStore = usePostStore()
            postStore.addPosts(items)

            if (feed) {
                addItemsToFeed(id, items.map(item => item.id))
                feed.data.total = data.data.total
            } else {
                const feedData = {
                    id,
                    data: {
                        ...data.data,
                        items: items.map(item => item.id),
                    },
                }

                addFeed(feedData)
            }
        }
    }

    async function fetchUserLikedPostsFeed(username: string) {
        const id = `user:${username}:liked_posts`
        const feed = feeds.value.find(item => item.id === id)

        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && feed.data.items.length >= feed.data.total) return

        const res = await api.feed.user.getLikedPosts(username, lastPostId)
        postsWithUserResponseHandler(id, res)
    }

    async function fetchTimelineFeed() {
        const id = `timeline`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0

        const lastPostId = feed ? Number(feed.data.items.at(-1)) : 0

        if (feed && offset > feed.data.total) return

        const res = await api.feed.getTimeline(lastPostId)
        postsWithUserResponseHandler(id, res)
    }

    function postsWithUserResponseHandler(id: string, res: PostFeedResponse) {
        const feed = feeds.value.find(item => item.id === id)
        const data = res.data

        if (data.success) {
            const items = data.data.items

            const userStore = useUserStore()
            userStore.addUsers(items.map(item => item.user))

            const postStore = usePostStore()
            postStore.addPosts(items.map(item => item.post))

            if (feed) {
                addItemsToFeed(id, items.map(item => item.post.id))
                feed.data.total = data.data.total
            } else {
                const feedData = {
                    id,
                    data: {
                        ...data.data,
                        items: items.map(item => item.post.id),
                    },
                }

                addFeed(feedData)
            }
        }
    }

    return {
        getFeedById,
        addItemToStartOfFeed,
        fetchUserPostsFeed,
        fetchTimelineFeed,
        fetchUserLikedPostsFeed,
    }
})
