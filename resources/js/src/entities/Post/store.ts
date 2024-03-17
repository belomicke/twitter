import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { IPost } from '@/shared/api/types/models/Post'
import { api } from '@/shared/api/methods'
import { useUserStore } from '@/entities/User/store'
import { useViewerStore } from '@/entities/Viewer/store'

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

            return posts.value.find(post => post.retweeted_post_id === id && post.user_id === viewer.id)
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

    function deletePost(item: number) {
        posts.value = posts.value.filter(post => post.id !== item)
    }

    function likePost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.liked = true
        post.likes_count += 1
    }

    function unlikePost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.liked = false
        post.likes_count -= 1
    }

    function retweetPost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.retweeted = true
        post.retweets_count += 1
    }

    function undoRetweetPost(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) return

        post.retweeted = false
        post.retweets_count -= 1
    }

    async function fetchPostById(id: number) {
        const post = posts.value.find(item => item.id === id)

        if (!post) {
            const res = await api.posts.getPostById(id)
            const data = res.data

            if (data.success) {
                const userStore = useUserStore()
                userStore.addUser(data.data.user)

                posts.value.push(data.data.post)
            }
        }
    }

    return {
        getPostById,
        getRetweetByPostId,
        addPost,
        addPosts,
        deletePost,
        fetchPostById,
        likePost,
        unlikePost,
        retweetPost,
        undoRetweetPost,
    }
})
