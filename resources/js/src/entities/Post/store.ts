import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { IPost } from '@/shared/api/types/models/Post'
import { api } from '@/shared/api/methods'
import { useViewerStore } from '@/entities/Viewer/store'
import { postApiItemHandle } from '@/entities/Post/helpers/postApiItemHandle'

export const usePostStore = defineStore('posts', () => {
    // store
    const posts = ref<IPost[]>([])

    // getters
    const getPostById = computed(() => {
        return (id: number) => {
            return posts.value.find(post => post.id === id)
        }
    })

    const getRetweetByPostId = computed(() => {
        return (id: number) => {
            const viewerStore = useViewerStore()
            const viewer = viewerStore.viewer

            if (!viewer) return

            return posts.value.find(post => post.retweeted_post_id === id && post.user_id === viewer.id && post.text === '')
        }
    })

    // actions
    function addPost(post: IPost) {
        if (!posts.value.find(item => item.id === post.id)) {
            posts.value.push(post)
        }
    }

    function addPosts(items: IPost[]) {
        items.forEach(item => addPost(item))
    }

    function deletePost(id: number) {
        posts.value = posts.value.filter(post => post.id !== id)
    }

    function deletePostRetweet(id: number) {
        const viewerStore = useViewerStore()
        const viewer = viewerStore.viewer

        if (!viewer) return

        const post = posts.value.find(post =>
            post.retweeted_post_id === id &&
            post.user_id === viewer.id &&
            post.text.length === 0
        )

        if (!post) return

        posts.value = posts.value.filter(item => item.id !== post.id)
    }

    function addPostToFavoriteList(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.is_favorite = true
    }

    function removePostFromFavoriteList(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.is_favorite = false
    }

    function incrementCommentsCount(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.reply_count += 1
    }

    function likePost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.liked = true
        post.like_count += 1
    }

    function unlikePost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.liked = false
        post.like_count -= 1
    }

    function bookmarkPost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.bookmarked = true
    }

    function unbookmarkPost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.bookmarked = false
    }

    function retweetPost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.retweeted = true
        post.retweet_count += 1
    }

    function undoRetweetPost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.retweeted = false
        post.retweet_count -= 1
    }

    function pinPost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        const pinnedPost = posts.value.find(item => (item.is_pinned === true && item.user_id === post.user_id))

        if (pinnedPost) {
            pinnedPost.is_pinned = false
        }

        post.is_pinned = true
    }

    function unpinPost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.is_pinned = false
    }

    async function fetchPostById(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) {
            const res = await api.posts.getById(id)
            const data = res.data

            if (data.success) {
                postApiItemHandle(data.data)
            }
        } else {
            if (post.retweeted_post_id) {
                const retweet = posts.value.find(item => item.id === post.retweeted_post_id)

                if (!retweet) {
                    const res = await api.posts.getById(post.retweeted_post_id)
                    const data = res.data

                    if (data.success) {
                        postApiItemHandle(data.data)
                    }
                }
            }

            if (post.in_reply_to_post_id) {
                const commentedPost = posts.value.find(item => item.id === post.in_reply_to_post_id)

                if (!commentedPost) {
                    const res = await api.posts.getById(post.in_reply_to_post_id)
                    const data = res.data

                    if (data.success) {
                        postApiItemHandle(data.data)
                    }
                }
            }
        }
    }

    return {
        getPostById,
        getRetweetByPostId,

        addPost,
        addPosts,
        deletePost,
        deletePostRetweet,
        fetchPostById,

        incrementCommentsCount,

        bookmarkPost,
        unbookmarkPost,

        likePost,
        unlikePost,

        retweetPost,
        undoRetweetPost,

        pinPost,
        unpinPost,

        addPostToFavoriteList,
        removePostFromFavoriteList
    }
})
