import { defineStore } from 'pinia'
import IUser, { ProfileBanners, ProfilePictures } from '@/shared/api/types/models/User'
import { api } from '@/shared/api/methods'
import { computed, ref } from 'vue'
import EditViewerPublicDataDTO from '@/features/account/edit-public-data/types/EditPublicDataDTO'

export const useUserStore = defineStore('users', () => {
    // store
    const users = ref<IUser[]>([])

    // getters
    const getUserByUsername = computed(() => {
        return (username: string) => {
            return users.value.find(user => user.username === username)
        }
    })

    const getUserById = computed(() => {
        return (id: number) => {
            return users.value.find(user => user.id === id)
        }
    })

    // actions
    function addUser(user: IUser) {
        if (!users.value.find(item => item.username === user.username)) {
            users.value.push(user)
        }
    }

    function addUsers(items: IUser[]) {
        items.forEach(item => addUser(item))
    }

    function editUser(id: number, data: EditViewerPublicDataDTO) {
        const user = users.value.find(item => item.id === id)

        if (!user) return

        user.name = data.name
        user.bio = data.bio ?? user.bio
        user.location = data.location ?? user.location
        user.link = data.link ?? user.link
    }

    function incrementFollowersCount(username: string) {
        const user = users.value.find(item => item.username === username)

        if (!user) return

        user.followers_count += 1
    }

    function decrementFollowersCount(username: string) {
        const user = users.value.find(item => item.username === username)

        if (!user) return

        user.followers_count -= 1
    }

    function incrementFollowsCount(username: string) {
        const user = users.value.find(item => item.username === username)

        if (!user) return

        user.follows_count += 1
    }

    function decrementFollowsCount(username: string) {
        const user = users.value.find(item => item.username === username)

        if (!user) return

        user.follows_count -= 1
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

    function changeProfilePicture(id: number, pictures: ProfilePictures) {
        const user = users.value.find(item => item.id === id)

        if (!user) return

        user.profile_picture = pictures
    }

    function changeProfileBanner(id: number, banner: ProfileBanners) {
        const user = users.value.find(item => item.id === id)

        if (!user) return

        user.profile_banner = banner
    }

    function incrementPostsCount(id: number) {
        const user = users.value.find(item => item.id === id)

        if (!user) return

        user.posts_count += 1
    }

    function decrementPostsCount(id: number) {
        const user = users.value.find(item => item.id === id)

        if (!user) return

        user.posts_count -= 1
    }

    function incrementLikedPostsCount(id: number) {
        const user = users.value.find(item => item.id === id)

        if (!user) return

        user.liked_posts_count += 1
    }

    function decrementLikedPostsCount(id: number) {
        const user = users.value.find(item => item.id === id)

        if (!user) return

        user.liked_posts_count -= 1
    }

    function followUser(username: string) {
        const user = users.value.find(item => item.username === username)

        if (!user) return

        if (user.following === false) {
            user.following = true
            user.followers_count++
        }
    }

    function unfollowUser(username: string) {
        const user = users.value.find(item => item.username === username)

        if (!user) return

        if (user.following === true) {
            user.following = false
            user.followers_count--
        }
    }

    return {
        getUserByUsername,
        getUserById,
        addUser,
        addUsers,
        fetchUser,
        editUser,
        changeProfilePicture,
        changeProfileBanner,

        incrementFollowersCount,
        decrementFollowersCount,

        incrementFollowsCount,
        decrementFollowsCount,

        incrementPostsCount,
        decrementPostsCount,

        incrementLikedPostsCount,
        decrementLikedPostsCount,

        followUser,
        unfollowUser
    }
})
