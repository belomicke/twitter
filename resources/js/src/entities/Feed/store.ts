import {
    computed,
    ref,
} from 'vue'

import { defineStore } from 'pinia'

import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'
import { api } from '@/shared/api/methods'
import { IFeed } from '@/shared/api/types/models/Feed'

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

    function addItemsToFeed(id: string, items: number[]) {
        const feed = feeds.value.find(item => item.id === id)

        if (feed) {
            feed.data.items.push(...items)
        }
    }

    async function fetchMyFollowingsPostsFeed() {
        const id = 'my-followings-posts'
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0

        if (feed && offset > feed.data.total || feed && !feed.data.hasNextPage) return

        const res = await api.feed.getFollowingsPosts({ offset, limit: 50 })
        const data = res.data

        if (data.success) {
            const items = data.data.items

            const postStore = usePostStore()
            postStore.addPosts(items.map(item => item.post))

            const userStore = useUserStore()
            userStore.addUsers(items.map(item => item.user))

            if (feed) {
                addItemsToFeed(id, items.map(item => item.post.id))
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

    async function fetchUserPostsFeed(username: string) {
        const id = `user:${username}:posts`
        const feed = feeds.value.find(item => item.id === id)

        const offset = feed ? feed.data.items.length : 0

        if (feed && offset > feed.data.total || feed && !feed.data.hasNextPage) return

        const res = await api.feed.user.getPosts(username, { offset, limit: 50 })
        const data = res.data

        if (data.success) {
            const items = data.data.items

            const postStore = usePostStore()
            postStore.addPosts(items)

            if (feed) {
                addItemsToFeed(id, items.map(item => item.id))
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

    return {
        getFeedById,
        fetchMyFollowingsPostsFeed,
        fetchUserPostsFeed,
    }
})
