import { defineStore } from 'pinia'
import IUser from '@/shared/api/types/models/User'
import { api } from '@/shared/api/methods'
import { computed, ref } from 'vue'
import EditViewerPublicDataDTO from '@/shared/api/types/DTO/account/EditViewerPublicDataDTO'

export const useUserStore = defineStore('users', () => {
    // store
    const users = ref<IUser[]>([])

    // getters
    const getUserByUsername = computed(() => {
        return (username: string) => {
            return users.value.find(user => user.username === username)
        }
    })

    // actions
    function addUser(user: IUser) {
        if (!users.value.find(item => item.username === user.username)) {
            users.value.push(user)
        }
    }

    function editUser(id: number, data: EditViewerPublicDataDTO) {
        const user = users.value.find(item => item.id === id)

        if (!user) return

        user.name = data.name
        user.bio = data.bio ?? user.bio
        user.location = data.location ?? user.location
        user.link = data.link ?? user.link
    }

    async function fetchUser(username: string) {
        const user = users.value.find(item => item.username === username)

        if (!user) {
            const res = await api.users.getUserByUsername(username)
            const data = res.data

            if (data.success) {
                users.value.push(data.data.user)
            }
        }
    }

    return {
        getUserByUsername,
        addUser,
        fetchUser,
        editUser,
    }
})
