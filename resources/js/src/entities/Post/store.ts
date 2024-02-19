import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { IPost } from '@/shared/api/types/models/Post'
import { api } from '@/shared/api/methods'
import { useUserStore } from '@/entities/User/store'

export const usePostStore = defineStore('posts', () => {
    // store
    const posts = ref<IPost[]>([])

    // getters
    const getPostById = computed(() => {
        return (id: number) => {
            return posts.value.find(post => post.id === id)
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
        addPost,
        addPosts,
        getPostById,
        fetchPostById,
    }
})
