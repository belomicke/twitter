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

    function incrementCommentsCount(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.reply_count += 1
    }

    function likePost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.favorited = true
        post.favorite_count += 1
    }

    function unlikePost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.favorited = false
        post.favorite_count -= 1
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

        likePost,
        unlikePost,

        retweetPost,
        undoRetweetPost
    }
})
