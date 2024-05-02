import { defineStore } from 'pinia'
import IUser, { ProfileBanners, ProfilePictures } from '@/shared/api/types/models/User'
import { computed, ref } from 'vue'
import { api } from '@/shared/api/methods'
import { useUserStore } from '@/entities/User/store'
import EditViewerPublicDataDTO from '@/features/account/edit-public-data/types/EditPublicDataDTO'

export const useViewerStore = defineStore('viewer', () => {
    // store
    const viewer = ref<IUser | undefined>(undefined)
    const isLoading = ref<boolean>(true)

    // getters
    const getViewer = computed(() => {
        return viewer.value
    })

    // actions
    async function fetchViewer() {
        if (!localStorage.getItem('token')) {
            isLoading.value = false
            return
        }

        if (!viewer.value) {
            try {
                const res = await api.account.getViewer()
                const data = res.data

                if (data.success) {
                    const userStore = useUserStore()

                    userStore.addUser(data.data.user)
                    viewer.value = data.data.user
                }
            } finally {
                isLoading.value = false
            }
        }
    }

    function editViewer(data: EditViewerPublicDataDTO) {
        if (!viewer.value) return

        const userStore = useUserStore()

        userStore.editUser(viewer.value.id, data)

        viewer.value = {
            ...viewer.value,
            ...data
        }
    }

    function changeProfilePicture(pictures: ProfilePictures) {
        const user = viewer.value

        if (!user) return

        const userStore = useUserStore()

        userStore.changeProfilePicture(user.id, pictures)

        viewer.value = {
            ...user,
            profile_picture: pictures
        }
    }

    function changeProfileBanner(banners: ProfileBanners) {
        const user = viewer.value

        if (!user) return

        const userStore = useUserStore()

        userStore.changeProfileBanner(user.id, banners)

        viewer.value = {
            ...user,
            profile_banner: banners
        }
    }

    function incrementPostsCount() {
        const user = viewer.value

        if (!user) return

        const userStore = useUserStore()

        userStore.incrementPostsCount(user.id)
    }

    function decrementPostsCount() {
        const user = viewer.value

        if (!user) return

        const userStore = useUserStore()

        userStore.decrementLikedPostsCount(user.id)
    }

    function incrementLikedPostsCount() {
        const user = viewer.value

        if (!user) return

        const userStore = useUserStore()

        userStore.incrementLikedPostsCount(user.id)
    }

    function decrementLikedPostsCount() {
        const user = viewer.value

        if (!user) return

        const userStore = useUserStore()

        userStore.decrementLikedPostsCount(user.id)
    }

    return {
        viewer,
        getViewer,
        isLoading,
        fetchViewer,
        editViewer,

        changeProfilePicture,
        changeProfileBanner,

        incrementPostsCount,
        decrementPostsCount,

        incrementLikedPostsCount,
        decrementLikedPostsCount
    }
})
