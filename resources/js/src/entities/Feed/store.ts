import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import { api } from '@/shared/api/methods'
import { IFeed } from '@/shared/api/types/models/Feed'
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

    async function fetchUserLikedPostsFeed(username: string) {
        const id = `user:${username}:liked_posts`
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

            const userStore = useUserStore()
            const postStore = usePostStore()

            items.forEach(item => {
                postStore.addPost(item.post)
                userStore.addUser(item.user)

                if (item.extensions.retweet !== null) {
                    postStore.addPost(item.extensions.retweet.post)
                    userStore.addUser(item.extensions.retweet.user)
                }
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
        fetchTimelineFeed,
        fetchUserLikedPostsFeed,
        fetchPostsByQuery
    }
})
