import { defineStore } from 'pinia'
import IUser from '@/shared/api/types/models/User'
import { api } from '@/shared/api/methods'
import { computed, ref } from 'vue'

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
    }
})
